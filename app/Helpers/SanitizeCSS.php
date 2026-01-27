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

    public static function sanitizeCSS(string $input): string
    {
        $parser = new Parser($input);
        $cssDoc = $parser->parse();

        $blacklistedProperties = ['-moz-binding', 'content'];
        $dangerousValues = ['url(', 'expression(', 'javascript:', 'data:'];

        foreach ($cssDoc->getAllRuleSets() as $ruleSet) {

            $rulesToRemove = [];

            foreach ($ruleSet->getRules() as $rule) {
                $property = strtolower($rule->getRule());
                $value = strtolower((string) $rule->getValue());

                if (
                    in_array($property, $blacklistedProperties, true) ||
                    self::containsDangerousValue($value, $dangerousValues)
                ) {
                    $rulesToRemove[] = $rule;
                }
            }

            foreach ($rulesToRemove as $rule) {
                $ruleSet->removeRule($rule);
            }

            // Remove @import ONCE per ruleset
            $ruleSet->removeMatchingRules('import');
        }

        return $cssDoc->render();
    }

    private static function containsDangerousValue(string $value, array $dangerousValues): bool
    {
        foreach ($dangerousValues as $danger) {
            if (str_contains($value, $danger)) {
                return true;
            }
        }
        return false;
    }

}
