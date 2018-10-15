// Created with Squiffy 5.1.2
// https://github.com/textadventures/squiffy
var squiffy = {};

(function(){
/* jshint quotmark: single */
/* jshint evil: true */


(function () {
    'use strict';

    squiffy.story = {};

    var initLinkHandler = function () {
        var handleLink = function (link) {
            if (link.hasClass('disabled')) return;
            var passage = link.data('passage');
            var section = link.data('section');
            var rotateAttr = link.attr('data-rotate');
            var sequenceAttr = link.attr('data-sequence');
            if (passage) {
                disableLink(link);
                squiffy.set('_turncount', squiffy.get('_turncount') + 1);
                passage = processLink(passage);
                if (passage) {
                    currentSection.append('<hr/>');
                    squiffy.story.passage(passage);
                }
                var turnPassage = '@' + squiffy.get('_turncount');
                if (turnPassage in squiffy.story.section.passages) {
                    squiffy.story.passage(turnPassage);
                }
                if ('@last' in squiffy.story.section.passages && squiffy.get('_turncount')>= squiffy.story.section.passageCount) {
                    squiffy.story.passage('@last');
                }
            }
            else if (section) {
                currentSection.append('<hr/>');
                disableLink(link);
                section = processLink(section);
                squiffy.story.go(section);
            }
            else if (rotateAttr || sequenceAttr) {
                var result = rotate(rotateAttr || sequenceAttr, rotateAttr ? link.text() : '');
                link.html(result[0].replace(/&quot;/g, '"').replace(/&#39;/g, '\''));
                var dataAttribute = rotateAttr ? 'data-rotate' : 'data-sequence';
                link.attr(dataAttribute, result[1]);
                if (!result[1]) {
                    disableLink(link);
                }
                if (link.attr('data-attribute')) {
                    squiffy.set(link.attr('data-attribute'), result[0]);
                }
                squiffy.story.save();
            }
        };

        squiffy.ui.output.on('click', 'a.squiffy-link', function () {
            handleLink(jQuery(this));
        });

        squiffy.ui.output.on('keypress', 'a.squiffy-link', function (e) {
            if (e.which !== 13) return;
            handleLink(jQuery(this));
        });

        squiffy.ui.output.on('mousedown', 'a.squiffy-link', function (event) {
            event.preventDefault();
        });
    };

    var disableLink = function (link) {
        link.addClass('disabled');
        link.attr('tabindex', -1);
    }
    
    squiffy.story.begin = function () {
        if (!squiffy.story.load()) {
            squiffy.story.go(squiffy.story.start);
        }
    };

    var processLink = function(link) {
		link = String(link);
        var sections = link.split(',');
        var first = true;
        var target = null;
        sections.forEach(function (section) {
            section = section.trim();
            if (startsWith(section, '@replace ')) {
                replaceLabel(section.substring(9));
            }
            else {
                if (first) {
                    target = section;
                }
                else {
                    setAttribute(section);
                }
            }
            first = false;
        });
        return target;
    };

    var setAttribute = function(expr) {
        var lhs, rhs, op, value;
        var setRegex = /^([\w]*)\s*=\s*(.*)$/;
        var setMatch = setRegex.exec(expr);
        if (setMatch) {
            lhs = setMatch[1];
            rhs = setMatch[2];
            if (isNaN(rhs)) {
				if(startsWith(rhs,"@")) rhs=squiffy.get(rhs.substring(1));
                squiffy.set(lhs, rhs);
            }
            else {
                squiffy.set(lhs, parseFloat(rhs));
            }
        }
        else {
			var incDecRegex = /^([\w]*)\s*([\+\-\*\/])=\s*(.*)$/;
            var incDecMatch = incDecRegex.exec(expr);
            if (incDecMatch) {
                lhs = incDecMatch[1];
                op = incDecMatch[2];
				rhs = incDecMatch[3];
				if(startsWith(rhs,"@")) rhs=squiffy.get(rhs.substring(1));
				rhs = parseFloat(rhs);
                value = squiffy.get(lhs);
                if (value === null) value = 0;
                if (op == '+') {
                    value += rhs;
                }
                if (op == '-') {
                    value -= rhs;
                }
				if (op == '*') {
					value *= rhs;
				}
				if (op == '/') {
					value /= rhs;
				}
                squiffy.set(lhs, value);
            }
            else {
                value = true;
                if (startsWith(expr, 'not ')) {
                    expr = expr.substring(4);
                    value = false;
                }
                squiffy.set(expr, value);
            }
        }
    };

    var replaceLabel = function(expr) {
        var regex = /^([\w]*)\s*=\s*(.*)$/;
        var match = regex.exec(expr);
        if (!match) return;
        var label = match[1];
        var text = match[2];
        if (text in squiffy.story.section.passages) {
            text = squiffy.story.section.passages[text].text;
        }
        else if (text in squiffy.story.sections) {
            text = squiffy.story.sections[text].text;
        }
        var stripParags = /^<p>(.*)<\/p>$/;
        var stripParagsMatch = stripParags.exec(text);
        if (stripParagsMatch) {
            text = stripParagsMatch[1];
        }
        var $labels = squiffy.ui.output.find('.squiffy-label-' + label);
        $labels.fadeOut(1000, function() {
            $labels.html(squiffy.ui.processText(text));
            $labels.fadeIn(1000, function() {
                squiffy.story.save();
            });
        });
    };

    squiffy.story.go = function(section) {
        squiffy.set('_transition', null);
        newSection();
        squiffy.story.section = squiffy.story.sections[section];
        if (!squiffy.story.section) return;
        squiffy.set('_section', section);
        setSeen(section);
        var master = squiffy.story.sections[''];
        if (master) {
            squiffy.story.run(master);
            squiffy.ui.write(master.text);
        }
        squiffy.story.run(squiffy.story.section);
        // The JS might have changed which section we're in
        if (squiffy.get('_section') == section) {
            squiffy.set('_turncount', 0);
            squiffy.ui.write(squiffy.story.section.text);
            squiffy.story.save();
        }
    };

    squiffy.story.run = function(section) {
        if (section.clear) {
            squiffy.ui.clearScreen();
        }
        if (section.attributes) {
            processAttributes(section.attributes);
        }
        if (section.js) {
            section.js();
        }
    };

    squiffy.story.passage = function(passageName) {
        var passage = squiffy.story.section.passages[passageName];
        if (!passage) return;
        setSeen(passageName);
        var masterSection = squiffy.story.sections[''];
        if (masterSection) {
            var masterPassage = masterSection.passages[''];
            if (masterPassage) {
                squiffy.story.run(masterPassage);
                squiffy.ui.write(masterPassage.text);
            }
        }
        var master = squiffy.story.section.passages[''];
        if (master) {
            squiffy.story.run(master);
            squiffy.ui.write(master.text);
        }
        squiffy.story.run(passage);
        squiffy.ui.write(passage.text);
        squiffy.story.save();
    };

    var processAttributes = function(attributes) {
        attributes.forEach(function (attribute) {
            if (startsWith(attribute, '@replace ')) {
                replaceLabel(attribute.substring(9));
            }
            else {
                setAttribute(attribute);
            }
        });
    };

    squiffy.story.restart = function() {
        if (squiffy.ui.settings.persist && window.localStorage) {
            var keys = Object.keys(localStorage);
            jQuery.each(keys, function (idx, key) {
                if (startsWith(key, squiffy.story.id)) {
                    localStorage.removeItem(key);
                }
            });
        }
        else {
            squiffy.storageFallback = {};
        }
        if (squiffy.ui.settings.scroll === 'element') {
            squiffy.ui.output.html('');
            squiffy.story.begin();
        }
        else {
            location.reload();
        }
    };

    squiffy.story.save = function() {
        squiffy.set('_output', squiffy.ui.output.html());
    };

    squiffy.story.load = function() {
        var output = squiffy.get('_output');
        if (!output) return false;
        squiffy.ui.output.html(output);
        currentSection = jQuery('#' + squiffy.get('_output-section'));
        squiffy.story.section = squiffy.story.sections[squiffy.get('_section')];
        var transition = squiffy.get('_transition');
        if (transition) {
            eval('(' + transition + ')()');
        }
        return true;
    };

    var setSeen = function(sectionName) {
        var seenSections = squiffy.get('_seen_sections');
        if (!seenSections) seenSections = [];
        if (seenSections.indexOf(sectionName) == -1) {
            seenSections.push(sectionName);
            squiffy.set('_seen_sections', seenSections);
        }
    };

    squiffy.story.seen = function(sectionName) {
        var seenSections = squiffy.get('_seen_sections');
        if (!seenSections) return false;
        return (seenSections.indexOf(sectionName) > -1);
    };
    
    squiffy.ui = {};

    var currentSection = null;
    var screenIsClear = true;
    var scrollPosition = 0;

    var newSection = function() {
        if (currentSection) {
            disableLink(jQuery('.squiffy-link', currentSection));
        }
        var sectionCount = squiffy.get('_section-count') + 1;
        squiffy.set('_section-count', sectionCount);
        var id = 'squiffy-section-' + sectionCount;
        currentSection = jQuery('<div/>', {
            id: id,
        }).appendTo(squiffy.ui.output);
        squiffy.set('_output-section', id);
    };

    squiffy.ui.write = function(text) {
        screenIsClear = false;
        scrollPosition = squiffy.ui.output.height();
        currentSection.append(jQuery('<div/>').html(squiffy.ui.processText(text)));
        squiffy.ui.scrollToEnd();
    };

    squiffy.ui.clearScreen = function() {
        squiffy.ui.output.html('');
        screenIsClear = true;
        newSection();
    };

    squiffy.ui.scrollToEnd = function() {
        var scrollTo, currentScrollTop, distance, duration;
        if (squiffy.ui.settings.scroll === 'element') {
            scrollTo = squiffy.ui.output[0].scrollHeight - squiffy.ui.output.height();
            currentScrollTop = squiffy.ui.output.scrollTop();
            if (scrollTo > currentScrollTop) {
                distance = scrollTo - currentScrollTop;
                duration = distance / 0.4;
                squiffy.ui.output.stop().animate({ scrollTop: scrollTo }, duration);
            }
        }
        else {
            scrollTo = scrollPosition;
            currentScrollTop = Math.max(jQuery('body').scrollTop(), jQuery('html').scrollTop());
            if (scrollTo > currentScrollTop) {
                var maxScrollTop = jQuery(document).height() - jQuery(window).height();
                if (scrollTo > maxScrollTop) scrollTo = maxScrollTop;
                distance = scrollTo - currentScrollTop;
                duration = distance / 0.5;
                jQuery('body,html').stop().animate({ scrollTop: scrollTo }, duration);
            }
        }
    };

    squiffy.ui.processText = function(text) {
        function process(text, data) {
            var containsUnprocessedSection = false;
            var open = text.indexOf('{');
            var close;
            
            if (open > -1) {
                var nestCount = 1;
                var searchStart = open + 1;
                var finished = false;
             
                while (!finished) {
                    var nextOpen = text.indexOf('{', searchStart);
                    var nextClose = text.indexOf('}', searchStart);
         
                    if (nextClose > -1) {
                        if (nextOpen > -1 && nextOpen < nextClose) {
                            nestCount++;
                            searchStart = nextOpen + 1;
                        }
                        else {
                            nestCount--;
                            searchStart = nextClose + 1;
                            if (nestCount === 0) {
                                close = nextClose;
                                containsUnprocessedSection = true;
                                finished = true;
                            }
                        }
                    }
                    else {
                        finished = true;
                    }
                }
            }
            
            if (containsUnprocessedSection) {
                var section = text.substring(open + 1, close);
                var value = processTextCommand(section, data);
                text = text.substring(0, open) + value + process(text.substring(close + 1), data);
            }
            
            return (text);
        }

        function processTextCommand(text, data) {
            if (startsWith(text, 'if ')) {
                return processTextCommand_If(text, data);
            }
            else if (startsWith(text, 'else:')) {
                return processTextCommand_Else(text, data);
            }
            else if (startsWith(text, 'label:')) {
                return processTextCommand_Label(text, data);
            }
            else if (/^rotate[: ]/.test(text)) {
                return processTextCommand_Rotate('rotate', text, data);
            }
            else if (/^sequence[: ]/.test(text)) {
                return processTextCommand_Rotate('sequence', text, data);   
            }
            else if (text in squiffy.story.section.passages) {
                return process(squiffy.story.section.passages[text].text, data);
            }
            else if (text in squiffy.story.sections) {
                return process(squiffy.story.sections[text].text, data);
            }
			else if (startsWith(text,'@') && !startsWith(text,'@replace')) {
				processAttributes(text.substring(1).split(","));
				return "";
			}
            return squiffy.get(text);
        }

        function processTextCommand_If(section, data) {
            var command = section.substring(3);
            var colon = command.indexOf(':');
            if (colon == -1) {
                return ('{if ' + command + '}');
            }

            var text = command.substring(colon + 1);
            var condition = command.substring(0, colon);
			condition = condition.replace("<", "&lt;");
            var operatorRegex = /([\w ]*)(=|&lt;=|&gt;=|&lt;&gt;|&lt;|&gt;)(.*)/;
            var match = operatorRegex.exec(condition);

            var result = false;

            if (match) {
                var lhs = squiffy.get(match[1]);
                var op = match[2];
                var rhs = match[3];

				if(startsWith(rhs,'@')) rhs=squiffy.get(rhs.substring(1));
				
                if (op == '=' && lhs == rhs) result = true;
                if (op == '&lt;&gt;' && lhs != rhs) result = true;
                if (op == '&gt;' && lhs > rhs) result = true;
                if (op == '&lt;' && lhs < rhs) result = true;
                if (op == '&gt;=' && lhs >= rhs) result = true;
                if (op == '&lt;=' && lhs <= rhs) result = true;
            }
            else {
                var checkValue = true;
                if (startsWith(condition, 'not ')) {
                    condition = condition.substring(4);
                    checkValue = false;
                }

                if (startsWith(condition, 'seen ')) {
                    result = (squiffy.story.seen(condition.substring(5)) == checkValue);
                }
                else {
                    var value = squiffy.get(condition);
                    if (value === null) value = false;
                    result = (value == checkValue);
                }
            }

            var textResult = result ? process(text, data) : '';

            data.lastIf = result;
            return textResult;
        }

        function processTextCommand_Else(section, data) {
            if (!('lastIf' in data) || data.lastIf) return '';
            var text = section.substring(5);
            return process(text, data);
        }

        function processTextCommand_Label(section, data) {
            var command = section.substring(6);
            var eq = command.indexOf('=');
            if (eq == -1) {
                return ('{label:' + command + '}');
            }

            var text = command.substring(eq + 1);
            var label = command.substring(0, eq);

            return '<span class="squiffy-label-' + label + '">' + process(text, data) + '</span>';
        }

        function processTextCommand_Rotate(type, section, data) {
            var options;
            var attribute = '';
            if (section.substring(type.length, type.length + 1) == ' ') {
                var colon = section.indexOf(':');
                if (colon == -1) {
                    return '{' + section + '}';
                }
                options = section.substring(colon + 1);
                attribute = section.substring(type.length + 1, colon);
            }
            else {
                options = section.substring(type.length + 1);
            }
            var rotation = rotate(options.replace(/"/g, '&quot;').replace(/'/g, '&#39;'));
            if (attribute) {
                squiffy.set(attribute, rotation[0]);
            }
            return '<a class="squiffy-link" data-' + type + '="' + rotation[1] + '" data-attribute="' + attribute + '" role="link">' + rotation[0] + '</a>';
        }

        var data = {
            fulltext: text
        };
        return process(text, data);
    };

    squiffy.ui.transition = function(f) {
        squiffy.set('_transition', f.toString());
        f();
    };

    squiffy.storageFallback = {};

    squiffy.set = function(attribute, value) {
        if (typeof value === 'undefined') value = true;
        if (squiffy.ui.settings.persist && window.localStorage) {
            localStorage[squiffy.story.id + '-' + attribute] = JSON.stringify(value);
        }
        else {
            squiffy.storageFallback[attribute] = JSON.stringify(value);
        }
        squiffy.ui.settings.onSet(attribute, value);
    };

    squiffy.get = function(attribute) {
        var result;
        if (squiffy.ui.settings.persist && window.localStorage) {
            result = localStorage[squiffy.story.id + '-' + attribute];
        }
        else {
            result = squiffy.storageFallback[attribute];
        }
        if (!result) return null;
        return JSON.parse(result);
    };

    var startsWith = function(string, prefix) {
        return string.substring(0, prefix.length) === prefix;
    };

    var rotate = function(options, current) {
        var colon = options.indexOf(':');
        if (colon == -1) {
            return [options, current];
        }
        var next = options.substring(0, colon);
        var remaining = options.substring(colon + 1);
        if (current) remaining += ':' + current;
        return [next, remaining];
    };

    var methods = {
        init: function (options) {
            var settings = jQuery.extend({
                scroll: 'body',
                persist: true,
                restartPrompt: true,
                onSet: function (attribute, value) {}
            }, options);

            squiffy.ui.output = this;
            squiffy.ui.restart = jQuery(settings.restart);
            squiffy.ui.settings = settings;

            if (settings.scroll === 'element') {
                squiffy.ui.output.css('overflow-y', 'auto');
            }

            initLinkHandler();
            squiffy.story.begin();
            
            return this;
        },
        get: function (attribute) {
            return squiffy.get(attribute);
        },
        set: function (attribute, value) {
            squiffy.set(attribute, value);
        },
        restart: function () {
            if (!squiffy.ui.settings.restartPrompt || confirm('Are you sure you want to restart?')) {
                squiffy.story.restart();
            }
        }
    };

    jQuery.fn.squiffy = function (methodOrOptions) {
        if (methods[methodOrOptions]) {
            return methods[methodOrOptions]
                .apply(this, Array.prototype.slice.call(arguments, 1));
        }
        else if (typeof methodOrOptions === 'object' || ! methodOrOptions) {
            return methods.init.apply(this, arguments);
        } else {
            jQuery.error('Method ' +  methodOrOptions + ' does not exist');
        }
    };
})();

var get = squiffy.get;
var set = squiffy.set;


squiffy.story.start = '_default';
squiffy.story.id = '502d954b2f';
squiffy.story.sections = {
	'_default': {
		'text': "<p>You are a black baseball player in the triple A league, the highest minor league level before the major league. You develop a simple shin splint, an injury that is common among runners, and players who must stop quickly (e.g, tennis players, baseball players).</p>\n<p>You notice that your lower right leg has been throbbing and tender after your practices.</p>\n<p><a class=\"squiffy-link link-section\" data-section=\"Ignore it\" role=\"link\" tabindex=\"0\">Ignore it</a>\n<a class=\"squiffy-link link-section\" data-section=\"Go to the team doctor\" role=\"link\" tabindex=\"0\">Go to the team doctor</a></p>",
		'passages': {
		},
	},
	'Ignore it': {
		'text': "<p>You&#39;ve never experienced this and aren&#39;t in a great amount of pain, so you decide to ignore it. You wouldn&#39;t want to risk being benched for too long and you want to demonstrate that you have great perseverance.</p>\n<p>You feel lonely hiding the secret about this injury. You wish you could confide in someone. One of your teammates, a white player named Danny, had a similar injury last season. You think he may be able to give you some helpful tips about how to recover faster.</p>\n<p><a class=\"squiffy-link link-section\" data-section=\"Talk to Danny about the injury\" role=\"link\" tabindex=\"0\">Talk to Danny about the injury</a>\n<a class=\"squiffy-link link-section\" data-section=\"Keep quiet and continue to ignore it\" role=\"link\" tabindex=\"0\">Keep quiet and continue to ignore it</a></p>",
		'passages': {
		},
	},
	'Keep quiet and continue to ignore it': {
		'text': "<p>After months and months of working with this hurt muscle.\n<a class=\"squiffy-link link-section\" data-section=\"It gets worse\" role=\"link\" tabindex=\"0\">It gets worse</a></p>",
		'passages': {
		},
	},
	'It gets worse': {
		'text': "<p>You continue to play, having to mask the pain you&#39;re experiencing.\n<a class=\"squiffy-link link-section\" data-section=\"The pain turns into a stress fracture\" role=\"link\" tabindex=\"0\">The pain turns into a stress fracture</a>.</p>",
		'passages': {
		},
	},
	'The pain turns into a stress fracture': {
		'text': "<p>Now the injury has progressed quite a lot. The pain you feel has spread from just your calf and shin to your whole right leg, and has continued to hurt beyond practice. You are in mild pain all the time and severe pain during and after practices. You can no longer ignore this pain because you can&#39;t play to nearly the same quality you uesd to be able to.</p>\n<p><a class=\"squiffy-link link-section\" data-section=\"You sit out a game\" role=\"link\" tabindex=\"0\">You sit out a game</a>\n<a class=\"squiffy-link link-section\" data-section=\"You play a game even though you are in a lot of pain\" role=\"link\" tabindex=\"0\">You play a game even though you are in a lot of pain</a>\n<a class=\"squiffy-link link-section\" data-section=\"Go back to Dr. Greenbaum\" role=\"link\" tabindex=\"0\">Go back to Dr. Greenbaum</a></p>",
		'passages': {
		},
	},
	'You sit out a game': {
		'text': "<p>Your performance is worsening.</p>\n<p><a class=\"squiffy-link link-section\" data-section=\"You tell your coach you need to sit out another game\" role=\"link\" tabindex=\"0\">You tell your coach you need to sit out another game</a>.</p>",
		'passages': {
		},
	},
	'You tell your coach you need to sit out another game': {
		'text': "<p>After missing several games, your coach sees you as a low value player and decides to demote you to the D league team.\n<a class=\"squiffy-link link-section\" data-section=\"You go to a lower league\" role=\"link\" tabindex=\"0\">You go to a lower league</a>.</p>",
		'passages': {
		},
	},
	'You play a game even though you are in a lot of pain': {
		'text': "<p>You step onto the field. You&#39;re proud of yourself for pushing through. However as soon as you sprint to catch the ball, you feel pins and needles. A pain courses through your body. You keep runing. The pain grows.</p>\n<p>You collapse in the field.</p>\n<p>The team doctor puts you a stretcher and they escort you off the field. After the game the coach comes to talk to you. He lets you know that he has noticed that you&#39;re playing worse lately. Given what happened in the game today, the team can no longer afford having you. They just don&#39;t have time to wait for your recovery. Your coach sees you as a low value player and decides to demote you to the D league team. </p>\n<p><a class=\"squiffy-link link-section\" data-section=\"You go to a lower league\" role=\"link\" tabindex=\"0\">You go to a lower league</a>. </p>",
		'passages': {
		},
	},
	'Talk to Danny about the injury': {
		'text': "<p>Danny is very receptive to you when you tell him about the injury. He gives you some helpful tips about stretches you can do to encourage a speedy recovery.</p>\n<p>The next day at practice though, he encourages you to show off a certain pivot and run move - one that he knows will exacerbate your pain. Everyone laughs as you&#39;re unable to do the drill correctly. The coach observes that clearly something is wrong and says he&#39;d like to talk to you.</p>\n<p><a class=\"squiffy-link link-section\" data-section=\"You talk to the coach\" role=\"link\" tabindex=\"0\">You talk to the coach</a></p>",
		'passages': {
		},
	},
	'You talk to the coach': {
		'text': "<p>He lets you know that he&#39;s noticed you playing worse lately. Given what happened in the game today, the team can no longer afford having you. They just don&#39;t have time to wait for your covery. Your coach sees you as a low value player and decides to demote you to the D league team.</p>\n<p><a class=\"squiffy-link link-section\" data-section=\"You go to a lower league\" role=\"link\" tabindex=\"0\">You go to a lower league</a></p>",
		'passages': {
		},
	},
	'You go to a lower league': {
		'text': "<p>Your injury has caused severe damage to your muscles and your performance continues to steadily decline along with your mental health.</p>\n<p><a class=\"squiffy-link link-section\" data-section=\"You fail to make it to the major leagues\" role=\"link\" tabindex=\"0\">You fail to make it to the major leagues</a></p>",
		'js': function() {
			unlock("michigantoday");
		},
		'passages': {
		},
	},
	'You fail to make it to the major leagues': {
		'text': "<p>The end.</p>",
		'passages': {
		},
	},
	'Go to the team doctor': {
		'text': "<p>The team doctor, Dr. Greenbaum, is white. There&#39;s a sentiment among the African American community of distrust of hospitals and doctors so you&#39;re wary of trusting this guy.</p>\n<p>However, after awhile, the radiating pain from your shin and calf starts to hurt not just after, but also during warmups and practice.</p>\n<p><a class=\"squiffy-link link-section\" data-section=\"Ignore it\" role=\"link\" tabindex=\"0\">Ignore it</a>\n<a class=\"squiffy-link link-section\" data-section=\"Go back to Dr. Greenbaum\" role=\"link\" tabindex=\"0\">Go back to Dr. Greenbaum</a></p>",
		'js': function() {
			unlock("nih1");
		},
		'passages': {
		},
	},
	'Go back to Dr. Greenbaum': {
		'text': "<p>The doctor tells you that your knee can be fixed through surgery. He hands you several sheets of paper to sign.</p>\n<p><a class=\"squiffy-link link-section\" data-section=\"Sign the papers\" role=\"link\" tabindex=\"0\">Sign the papers</a>\n<a class=\"squiffy-link link-section\" data-section=\"Refuse to sign as the papers seem excessive\" role=\"link\" tabindex=\"0\">Refuse to sign as the papers seem excessive</a></p>",
		'js': function() {
			unlock("nejm1");
		},
		'passages': {
		},
	},
	'Sign the papers': {
		'text': "<p>You go under surgery. When you wake up you feel hazy, but the pain is dulled. The hospital tells you to leave without allowing you to recover fully in the hospital&#39;s custody.</p>\n<p>You have not fully recovered but they&#39;re pushing you out. Your injury does not get better. You have no choice.</p>\n<p><a class=\"squiffy-link link-section\" data-section=\"Recover by yourself at home\" role=\"link\" tabindex=\"0\">Recover by yourself at home</a></p>",
		'js': function() {
			unlock("newyorker1");
		},
		'passages': {
		},
	},
	'Recover by yourself at home': {
		'text': "<p>Over the next couple of adys you realize your calf has continued to swell and does not seem to get better.</p>\n<p><a class=\"squiffy-link link-section\" data-section=\"You sit out a game\" role=\"link\" tabindex=\"0\">You sit out a game</a></p>",
		'passages': {
		},
	},
	'Refuse to sign as the papers seem excessive': {
		'text': "<p>You decide to go to a black doctor. The doctor tells you that you were suffering from a shin splint due to excessive running during practice and training. Your shin splint developed into a stress fracture.</p>\n<p>All you need to do is rest, ice and elevate your shin and calf after practice. He suggests that you don&#39;t run as intensely and work on anaerobic exercises for a couple of months. He gives you several stretchnig exercises and prescribes you calcium and vitamin D.</p>\n<p>Now that you&#39;re fully recovered you can return to working on making it to the major leagues!</p>",
		'js': function() {
			unlock("finished_injury");
		},
		'passages': {
		},
	},
}
})();