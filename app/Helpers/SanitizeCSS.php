<?php
namespace App\Helpers;
use Sabberworm\CSS\Parser;

class SanitizeCSS
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function sanitizeCSS($input) {
        $parser = new Parser($input);
        $cssDoc = $parser->parse();

        $blacklistedProperties = ['-moz-binding', 'content'];
        $dangerousValues = ['url(', 'expression(', 'javascript:', 'data:'];

        // Remove unsafe rules
        foreach ($cssDoc->getAllRuleSets() as $ruleSet) {
            foreach ($ruleSet->getRules() as $rule) {
                $property = strtolower($rule->getRule());
                $value = strtolower((string) $rule->getValue());

                if (in_array($property, $blacklistedProperties) ||
                    collect($dangerousValues)->contains(fn($v) => str_contains($value, $v))) {
                    $ruleSet->removeRule($rule);
                }

                $ruleSet->removeMatchingRules("@import");
            }
        }

        return $cssDoc->render();
    }
}
