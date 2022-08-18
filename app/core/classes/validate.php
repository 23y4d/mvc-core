<?php 

namespace app\core\classes;

trait validate
{

    public static $RULE_REQUIRED     = 'required';
    public static $RULE_EMAIL        = 'email';
    public static $RULE_MIN          = 'min';
    public static $RULE_MAX          = 'max';
    public static $RULE_MATCH        = 'match';
    public static $RULE_UNIQUE       = 'unique';

    private  $erorrs = [];

    final public function validate(array $rules = null): bool
    {

        $rules = $rules === null ? $this->rules() : $rules;
        foreach ($rules as $attr => $rules) {
            $value = $this->{$attr};
            if(array_key_exists($attr,$this->erorrs))
                continue;
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (is_array($rule)) {
                    $ruleName = $rule[0];
                }
                if ($ruleName === self::$RULE_REQUIRED && !$value) {
                    $this->addError($attr, self::$RULE_REQUIRED);
                }
                if ($ruleName === self::$RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($attr, self::$RULE_EMAIL, [
                        'email' => $value
                    ]);
                }
                if ($ruleName === self::$RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addError($attr, self::$RULE_MIN, [
                        'min' => $rule['min']
                    ]);
                }
                if ($ruleName === self::$RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addError($attr, self::$RULE_MAX, [
                        'max' => $rule['max']
                    ]);
                }
                if ($ruleName === self::$RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $this->addError($attr, self::$RULE_MATCH, [
                        'match' => $rule['match']
                    ]);
                }
            }
        }

        return empty($this->erorrs) ? true : false;
    }


    public function hasError($attr)
    {
        return $this->erorrs[$attr] ?? false;
    }

    public function firstError($attr)
    {
        return $this->erorrs[$attr][0] ?? false;
    }

    private function addError($attr, $rule, $params = [])
    {
        $message = $this->errorMessages()[$rule] ?? '';
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", (string) $value, $message);
        }
        $this->erorrs[$attr][] = $message;
    }

    private function errorMessages()
    {
        return [
            self::$RULE_REQUIRED => 'This filed is required',
            self::$RULE_EMAIL    => 'This filed must be valid {email} address',
            self::$RULE_MIN      => 'This filed must be {min}  ',
            self::$RULE_MAX      => 'This filed must be valid {max} ',
            self::$RULE_MATCH    => 'This filed must be  {match} '
        ];
    }



}
