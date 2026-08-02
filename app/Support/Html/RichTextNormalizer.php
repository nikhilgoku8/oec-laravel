<?php

namespace App\Support\Html;

use DOMDocument;
use DOMElement;
use DOMNode;

/**
 * Browser-like HTML normalization for rich-text content (tables, lists, etc.).
 * Parses via DOMDocument, repairs orphan table structures, and serializes.
 * Does not use regex-based HTML rewriting.
 */
class RichTextNormalizer
{
    private const TABLE_SECTION_TAGS = ['tbody', 'thead', 'tfoot'];

    private const TABLE_INTERNAL_TAGS = [
        'tr',
        'td',
        'th',
        'tbody',
        'thead',
        'tfoot',
        'caption',
        'colgroup',
        'col',
    ];

    private const TABLE_CONTEXT_TAGS = [
        'table',
        'tbody',
        'thead',
        'tfoot',
        'tr',
        'colgroup',
    ];

    public function normalize(?string $html): string
    {
        if ($html === null) {
            return '';
        }

        if (trim($html) === '') {
            return $html;
        }

        $previous = libxml_use_internal_errors(true);

        try {
            $dom = new DOMDocument('1.0', 'UTF-8');
            $dom->loadHTML(
                '<?xml encoding="UTF-8"><div id="__rich_text_root__">'.$html.'</div>',
                LIBXML_HTML_NODEFDTD
            );

            $root = $dom->getElementById('__rich_text_root__');
            if (! $root instanceof DOMElement) {
                return $html;
            }

            $this->repairOrphanTableStructures($dom, $root);

            $normalized = '';
            foreach (iterator_to_array($root->childNodes) as $child) {
                $normalized .= $dom->saveHTML($child);
            }

            return $normalized;
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($previous);
        }
    }

    private function repairOrphanTableStructures(DOMDocument $dom, DOMElement $root): void
    {
        $this->wrapOrphanTableChildren($dom, $root);

        $elements = [];
        foreach ($root->getElementsByTagName('*') as $element) {
            if ($element instanceof DOMElement) {
                $elements[] = $element;
            }
        }

        foreach ($elements as $element) {
            if (strtolower($element->tagName) === 'table') {
                continue;
            }

            $this->wrapOrphanTableChildren($dom, $element);
        }
    }

    private function wrapOrphanTableChildren(DOMDocument $dom, DOMElement $parent): void
    {
        $parentTag = strtolower($parent->tagName);
        if (in_array($parentTag, self::TABLE_CONTEXT_TAGS, true)) {
            return;
        }

        $buffer = [];

        $flush = function () use (&$buffer, $dom, $parent): void {
            if ($buffer === []) {
                return;
            }

            $table = $dom->createElement('table');
            $tbody = $dom->createElement('tbody');
            $parent->insertBefore($table, $buffer[0]);

            foreach ($buffer as $node) {
                $tag = strtolower($node->nodeName);

                if (in_array($tag, self::TABLE_SECTION_TAGS, true)) {
                    $table->appendChild($node);
                    continue;
                }

                if ($tag === 'tr') {
                    $tbody->appendChild($node);
                    continue;
                }

                if (in_array($tag, ['td', 'th'], true)) {
                    $tr = $dom->createElement('tr');
                    $tr->appendChild($node);
                    $tbody->appendChild($tr);
                    continue;
                }

                $table->appendChild($node);
            }

            if ($tbody->hasChildNodes()) {
                if ($table->firstChild) {
                    $table->insertBefore($tbody, $table->firstChild);
                } else {
                    $table->appendChild($tbody);
                }
            }

            $buffer = [];
        };

        foreach (iterator_to_array($parent->childNodes) as $child) {
            if (
                $child instanceof DOMElement
                && in_array(strtolower($child->tagName), self::TABLE_INTERNAL_TAGS, true)
            ) {
                $buffer[] = $child;
                continue;
            }

            $flush();
        }

        $flush();
    }
}
