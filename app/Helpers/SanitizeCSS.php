<?php
namespace App\Helpers;
use Sabberworm\CSS\OutputFormat;
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

                $valueObj = $rule->getValue();

                if (is_string($valueObj)) {
                    $value = strtolower($valueObj);
                } elseif ($valueObj !== null) {
                    $value = strtolower(
                        $valueObj->render(OutputFormat::createCompact())
                    );
                } else {
                    $value = '';
                }

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
