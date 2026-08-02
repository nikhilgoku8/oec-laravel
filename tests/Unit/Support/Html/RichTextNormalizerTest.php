<?php

use App\Support\Html\RichTextNormalizer;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Exact Product Specification HTML from production DB (products 1210, 1850, 4991).
 */
function productSpecFixture(int $productId): string
{
    return match ($productId) {
        1210 => '<table><tbody><tr><td>Connector Type</td><td>Copper</td></tr><tr><td>Conductor Material</td><td>Copper Only</td></tr><tr><td>Standard Material</td><td>Copper</td></tr><tr><td>Standard Finish</td><td>Electro Tin plated</td></tr><tr><td>Color</td>
<td>Gray</td></tr><tr><td>Barrel Type</td><td>Standard</td></tr><tr><td>Barrel Style</td><td>Chamfered</td></td></tr></tbody></table>',
        1850 => 'White</td></tr><tr><td>Barrel Type</td><td>Long</td></tr><tr><td>Barrel Style</td><td>Chamfered</td></tr><tr><td>Tang Type</td><td>Narrow</td></tr><tr><td>No of Holes</td><td>2</td></tr></tbody></table>',
        4991 => 'ENS18126</td></tr><tr><td>Cover type</td><td>Screw</td></tr><tr><td>Mounting method</td><td>Surface</td></tr><tr><td>Mounting hole details</td><td>Thru holes</td></tr><tr><td>Material</td><td>Carbon Steel</td></tr><tr><td>Wall Thickness</td><td>16 Gauge</td></tr><tr><td>Finish color</td><td>Painted</td></tr><tr><td>Color</td><td>ANSI 61 gray</td></tr></tbody></table>',
        default => throw new InvalidArgumentException("No fixture for product {$productId}"),
    };
}

function renderNestedPdf(string $innerHtml): void
{
    $html = '<html><body><table><tr><td>'.$innerHtml.'</td><td></td></tr></table></body></html>';
    $options = new Options;
    $options->set('isHtml5ParserEnabled', true);
    $pdf = new Dompdf($options);
    $pdf->loadHtml($html);
    $pdf->render();
}

function expectPdfFails(string $innerHtml): void
{
    $failed = false;
    try {
        renderNestedPdf($innerHtml);
    } catch (Throwable) {
        $failed = true;
    }

    expect($failed)->toBeTrue();
}

function expectPdfSucceeds(string $innerHtml): void
{
    renderNestedPdf($innerHtml);
    expect(true)->toBeTrue();
}

beforeEach(function () {
    $this->normalizer = new RichTextNormalizer;
});

test('empty and null html normalize safely', function () {
    expect($this->normalizer->normalize(null))->toBe('');
    expect($this->normalizer->normalize(''))->toBe('');
    expect($this->normalizer->normalize('   '))->toBe('   ');
});

test('product 1210 extra closing td is repaired and renders in nested pdf layout', function () {
    $before = productSpecFixture(1210);
    $after = $this->normalizer->normalize($before);

    expect($after)->not->toContain('</td></td>');
    expect($after)->toContain('<table');
    expect($after)->toContain('Barrel Style');
    expect($after)->toContain('Chamfered');

    expectPdfFails($before);
    expectPdfSucceeds($after);
});

test('product 1850 truncated orphan table fragment is wrapped and renders', function () {
    $before = productSpecFixture(1850);
    $after = $this->normalizer->normalize($before);

    expect($before)->not->toContain('<table');
    expect($after)->toContain('<table');
    expect($after)->toContain('<tr>');
    expect($after)->toContain('Barrel Type');
    expect($after)->toContain('White');

    expectPdfFails($before);
    expectPdfSucceeds($after);
});

test('product 4991 truncated orphan table fragment is wrapped and renders', function () {
    $before = productSpecFixture(4991);
    $after = $this->normalizer->normalize($before);

    expect($before)->not->toContain('<table');
    expect($after)->toContain('<table');
    expect($after)->toContain('Cover type');
    expect($after)->toContain('ENS18126');

    expectPdfFails($before);
    expectPdfSucceeds($after);
});

test('missing tr closer is normalized without breaking nested pdf layout', function () {
    $before = '<table><tbody><tr><td>CU Compact Class-B, C</td><td>#4 AWG</td><tr><td>CU Compact Class-B, C Range</td><td>#4 AWG</td></tr><tr><td>Expanded Conductor Range</td><td>#4 - #6</td></tr></tbody></table>';
    $after = $this->normalizer->normalize($before);

    expect($after)->toContain('</tr><tr>');
    expect(substr_count(strtolower($after), '</tr>'))->toBeGreaterThanOrEqual(3);
    expectPdfSucceeds($after);
});

test('well-formed table remains a single table after normalization', function () {
    $before = '<table><tbody><tr><td>Label</td><td>Value</td></tr></tbody></table>';
    $after = $this->normalizer->normalize($before);

    expect(substr_count(strtolower($after), '<table'))->toBe(1);
    expect($after)->toContain('Label');
    expect($after)->toContain('Value');
    expectPdfSucceeds($after);
});
