<?php

namespace App\Renderers;

use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;

class SandboxedHeadingRenderer implements NodeRendererInterface
{
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): HtmlElement
    {
        if (! $node instanceof Heading) {
            throw new \InvalidArgumentException('Expected Heading node.');
        }

        $attrs = $node->data->get('attributes') ?? [];

        $attrs['class'] = trim($attrs['class'] ?? '') . ' h';
        $attrs['class'] = trim(($attrs['class'] ?? '') . ' h' . $node->getLevel());

        return new HtmlElement(
            'p',
            $attrs,
            $childRenderer->renderNodes($node->children())
        );
    }
}