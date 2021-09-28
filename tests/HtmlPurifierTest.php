<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

final class HtmlPurifierTest extends TestCase
{
    public function testMaliciousCode()
    {
        $this->assertEquals(
            '',
            Bnomei\HtmlPurifier::purify('<img src="javascript:evil();" onload="evil();" />')
        );
    }

    public function testRemovesSrcset()
    {
        $this->assertEquals(
            '<img src="images/space-needle.jpg" alt="space-needle.jpg" />',
            Bnomei\HtmlPurifier::purify('<img src="images/space-needle.jpg" srcset="images/space-needle.jpg 1x, images/space-needle-2x.jpg 2x,
images/space-needle-hd.jpg 3x">')
        );

        $this->assertEquals(
            '',
            Bnomei\HtmlPurifier::purify('<img data-sizes="auto" data-src="images/space-needle.jpg" data-srcset="images/space-needle.jpg 1x, images/space-needle-2x.jpg 2x,
images/space-needle-hd.jpg 3x">')
        );
    }

    public function testMissingEndtags()
    {
        $this->assertEquals(
            '<b>Bold</b>',
            Bnomei\HtmlPurifier::purify('<b>Bold')
        );
    }

    public function testIllegalNestingFixed()
    {
        $this->assertEquals(
            '<b>Inline <del>context No block allowed</del></b>',
            Bnomei\HtmlPurifier::purify('<b>Inline <del>context <div>No block allowed</div></del></b>')
        );
    }

    public function testDeprecatedTagsConverted()
    {
        $this->assertEquals(
            '<div style="text-align:center;">Centered</div>',
            Bnomei\HtmlPurifier::purify('<center>Centered</center>')
        );
    }

    public function testCSSValidated()
    {
        $this->assertEquals(
            '<span>Text</span>',
            Bnomei\HtmlPurifier::purify('<span style="color:#COW;float:around;text-decoration:blink;">Text</span>')
        );
    }

    public function testRichFormattingPreserved()
    {
        $this->assertEquals(
            '<table>
  <caption>
    Cool table
  </caption>
  <tfoot>
    <tr>
      <th>I can do so much!</th>
    </tr>
  </tfoot>
  <tbody><tr>
    <td style="font-size:16pt;color:#F00;font-family:sans-serif;text-align:center;">Wow</td>
  </tr>
</tbody></table>',
            Bnomei\HtmlPurifier::purify('<table>
  <caption>
    Cool table
  </caption>
  <tfoot>
    <tr>
      <th>I can do so much!</th>
    </tr>
  </tfoot>
  <tr>
    <td style="font-size:16pt;
      color:#F00;font-family:sans-serif;
      text-align:center;">Wow</td>
  </tr>
</table>')
        );
    }
}
