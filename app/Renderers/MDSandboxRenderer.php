<?php

namespace App\Renderers;

use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use Spatie\LaravelMarkdown\MarkdownRenderer;

class MDSandboxRenderer extends MarkdownRenderer {
    public function configureCommonMarkEnvironment(EnvironmentBuilderInterface $environment) : void
    {      
        $environment->addRenderer(Heading::class, new SandboxedHeadingRenderer());
        parent::configureCommonMarkEnvironment($environment);
    }
}