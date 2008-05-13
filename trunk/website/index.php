<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
    <head>
        <title>Celerity</title>
        <meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8" />
        <link rel="stylesheet" type="text/css" media="screen" href="css/screen.css" />
    </head>
    <body>
    	<div id="container">
            <div id="header">
                <h1><a href=".">Celerity</a></h1>
                <div id="tagline">
                    { French célérité > Latin celeritas > Latin celer, fast, swift. <br />
                    Rapidity of motion; quickness; swiftness. }
                </div>
                <div id="leftSlice"></div>
                <div id="rightSlice"></div>
            </div>
            <div id="nav">
                <ul>
                    <li><a accesskey="p" title="Celerity at Rubyforge" href="http://rubyforge.org/projects/celerity/" hreflang="en">Rubyforge project</a></li>
                    <li><a accesskey="d" title="Download Celerity" href="http://rubyforge.org/frs/?group_id=6198" hreflang="en">Download</a></li>
                    <li><a accesskey="f" title="Discuss Celerity" href="http://rubyforge.org/forum/?group_id=6198" hreflang="en">Forum</a></li>
                    <li><a accesskey="m" title="Stay up-to-date" href="http://rubyforge.org/mail/?group_id=6198" hreflang="en">Mailing lists</a></li>
                    <li><a accesskey="s" title="We've proved the infinite monkey theorem" href="http://celerity.rubyforge.org/svn/" hreflang="en">Browse source</a></li>
                    <li><a accesskey="b" title="Report and browse bugs" href="http://rubyforge.org/tracker/?atid=24033&amp;group_id=6198&amp;func=browse" hreflang="en">Bug tracker</a></li>
                    <li><a accesskey="e" title="Request and browse new features" href="http://rubyforge.org/tracker/?atid=24036&amp;group_id=6198&amp;func=browse" hreflang="en">Feature tracker</a></li>
                </ul>
            </div>
            <div id="content">
                <a href="http://rubyforge.org/frs/?group_id=6198" id="download" title="Latest version: 0.0.1">Download &#x2192;</a>

                <h2>What is Celerity?</h2>
                <p>Celerity is a <a href="http://jruby.codehaus.org/">JRuby</a> library for easy and fast functional test automation for web applications. It is a wrapper around the <a href="http://htmlunit.sourceforge.net/">HtmlUnit</a> Java library and is currently aimed at providing the same API and functionality as <a href="http://wtr.rubyforge.org/">Watir</a>.</p>
                
                <h2>Features</h2>
                <ul>
                    <li>Fast: No time-consuming GUI rendering or unessential downloads</li>
                    <li>Scalable: Java threads lets you run tests in parallel</li>
                    <li>Easy to use: Simple API</li>
                    <li>Portable: Cross-platform</li>
                    <li>Unintrusive: No browser window interrupting your workflow (runs in background)</li>
                </ul>
                
                <h2>Requirements</h2>
                <ul>
                    <li>JRuby 1.1</li>
                    <li>Java 6</li>
                </ul>
                
                <h2>Background</h2>
                <p><a href="http://www.finn.no/">FINN.no</a> is a top provider of online classifieds in Europe. Consequently automated functional testing is an essential part of our quality assurance effort. As of spring 2008 our Watir test suite, consisting of 340 test cases (which only covers part of our application), completes in 3 hours. Obviously, not optimal for an agile development environment.</p>
                <p>We need a faster alternative. At the same time, we enjoy working with Ruby and Watir's API. By providing this API on top of HtmlUnit, we hope to significantly speed up test suite execution, while avoiding a rewrite of our existing test suite.</p>
                
                <h2>Installing Celerity</h2>
                <pre>
                <code>
jruby -S gem install celerity
                </code>
                </pre>

                <h2>Code example</h2>
                <pre>
                <code>
require "celerity" 

browser = Celerity::IE.new
browser.goto('http://www.google.com')
browser.text_field(:name, 'q').value = "Celerity" 
browser.button(:name, 'btnG').click

puts "yay" if browser.text.include? 'celerity.rubyforge.org'
                </code>
                </pre>

                <h2>How to submit patches</h2>
                <p>Read the <a href="http://drnicwilliams.com/2007/06/01/8-steps-for-fixing-other-peoples-code/">8 steps for fixing other people&#8217;s code</a>. The trunk repository is <code>svn://rubyforge.org/var/svn/celerity/trunk</code> for anonymous access. Failing specs for issues/features you don't know how to implement yourself are most welcome.</p>

                <h2>License</h2>
                <p>Celerity is licensed under the <a href="http://www.gnu.org/licenses/gpl-3.0.html">GPLv3 license</a>.</p>

                <h2>Contact</h2>
                <p>Comments are welcome. You can reach us through our <a href="http://rubyforge.org/mail/?group_id=6198">mailing lists</a>, our <a href="http://rubyforge.org/forum/?group_id=6198">forum</a>, or our individual email addresses below.</p>
                
                <h2>Developers</h2>
                <ul>
                    <li><a href="mailto:tinius.alexander@lystadonline.no">T. Alexander Lystad</a></li>
                    <li><a href="mailto:knut.johannes.dahle@gmail.com">Knut Johannes Dahle</a></li>
                    <li><a href="mailto:jari.bakken@finntech.no">Jari Bakken</a></li>
                </ul>
            </div>
        </div>
        <div id="footer">
            <p>
                <span class="w3cbutton">
                    <a href="http://validator.w3.org/check?uri=referer" title="Valid XHTML 1.0 Strict" hreflang="en">
                            <span class="w3c">W3C</span>
                            <span class="spec">XHTML 1.0</span>
                    </a>
                </span>
                &nbsp;
                <span class="w3cbutton">
                    <a href="http://jigsaw.w3.org/css-validator/check/referer" title="Valid CSS" hreflang="en">
                            <span class="w3c">W3C</span>
                            <span class="spec">CSS</span>
                    </a>
                </span>
                &nbsp;
                <span class="w3cbutton">
                    <a href="http://www.w3.org/WAI/WCAG1AAA-Conformance" title="Conforming with the highest level (AAA) of the Web Content Accessibility Guidelines 1.0" hreflang="en">
                            <span class="w3c">W3C</span>
                            <span class="spec">WAI&#8209;<span class="red">AAA</span>&nbsp;WCAG&nbsp;1.0</span>
                    </a>
                </span>
            </p>
            <address>
                <a href="mailto:tinius.alexander@lystadonline.no">T. Alexander Lystad</a>, 13th May 2008
            </address>
        </div>
    </body>
</html>