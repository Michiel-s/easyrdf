<?php

namespace Test\Examples;

use Test\TestCase;

/**
 * EasyRdf
 *
 * LICENSE
 *
 * Copyright (c) 2021 Konrad Abicht <hi@inspirito.de>
 * Copyright (c) 2009-2020 Nicholas J Humfrey.  All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 *    this list of conditions and the following disclaimer in the documentation
 *    and/or other materials provided with the distribution.
 * 3. The name of the author 'Nicholas J Humfrey" may be used to endorse or
 *    promote products derived from this software without specific prior
 *    written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @copyright  Copyright (c) 2021 Konrad Abicht <hi@inspirito.de>
 * @copyright  Copyright (c) 2009-2020 Nicholas J Humfrey
 * @license    https://www.opensource.org/licenses/bsd-license.php
 */
class HttpgetTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (false == weAreOnline()) {
            $this->markTestSkipped('Test skipped due to no internet connection.');
        }
    }

    public function testNoParams()
    {
        $output = executeExample('httpget.php');
        $this->assertStringContainsString('<title>Test EasyRdf HTTP Client Get</title>', $output);
        $this->assertStringContainsString('<h1>Test EasyRdf HTTP Client Get</h1>', $output);
        $this->assertStringContainsString(
            '<input type="text" name="uri" id="uri" value="http://tomheath.com/id/me" size="50" />',
            $output
        );
        $this->assertStringContainsString(
            '<option value="application/rdf+xml">application/rdf+xml</option>',
            $output
        );
        $this->assertStringContainsString(
            '<option value="text/html">text/html</option>',
            $output
        );
    }

    public function testHtml()
    {
        $output = executeExample(
            'httpget.php',
            [
                'uri' => 'http://tomheath.com/id/me',
                'accept' => 'text/html',
            ]
        );
        $this->assertStringContainsString('<title>Test EasyRdf HTTP Client Get</title>', $output);
        $this->assertStringContainsString('<h1>Test EasyRdf HTTP Client Get</h1>', $output);
        $this->assertStringContainsString('<b>Content-type</b>: text/html', $output);
        $this->assertStringContainsString('&lt;h1&gt;Home - Tom Heath&lt;/h1&gt;', $output);
    }

    public function testRdfXml()
    {
        $output = executeExample(
            'httpget.php',
            [
                'uri' => 'http://tomheath.com/id/me',
                'accept' => 'application/rdf+xml',
            ]
        );
        $this->assertStringContainsString('<title>Test EasyRdf HTTP Client Get</title>', $output);
        $this->assertStringContainsString('<h1>Test EasyRdf HTTP Client Get</h1>', $output);
        $this->assertStringContainsString('<b>Content-type</b>: application/rdf+xml', $output);
        $this->assertStringContainsString(
            '&lt;foaf:Person rdf:about=&quot;http://tomheath.com/id/me&quot;&gt;',
            $output
        );
    }
}
