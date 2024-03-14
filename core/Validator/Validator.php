<?php

namespace Core\Validator;

use Core\Auth\AuthInterface;

class Validator implements ValidatorInterface
{

    private array $errors = [];

    private array $data;

    public function __construct(
        private AuthInterface $auth
    ) {
    }

    public function validate(array $data, array $rules): bool
    {
        $this->errors = [];
        $this->data = $data;

        foreach ($rules as $key => $rule) {
            $rules = $rule;

            foreach ($rules as $rule) {
                $rule = explode(':', $rule);

                $ruleName = $rule[0];
                $ruleValue = $rule[1] ?? null;

                $error = $this->validateRule($key, $ruleName, $ruleValue);

                if ($error) {
                    $this->errors[$key][] = $error;
                }
            }
        }

        return empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    private function validateRule(string $key, string $ruleName, string $ruleValue = null): string|false
    {
        $value = $this->data[$key];

        switch ($ruleName) {
            case 'required':
                if (empty($value)) {
                    return "Поле $key обязательное";
                }
                break;
            case 'min':
                if (strlen($value) < $ruleValue) {
                    return "Поле $key должно быть не короче $ruleValue символов";
                }
                break;
            case 'max':
                if (strlen($value) > $ruleValue) {
                    return "Поле $key должно быть не длиннее $ruleValue символов";
                }
                break;
            case 'email':
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    return "Field $key must be a valid email address";
                }
                break;
            case 'confirmed':
                if ($value !== $this->data["{$key}_confirmation"]) {
                    return "Field $key must be confirmed";
                }
                break;
            case 'already_exist':
                if ($this->auth->is_user_exist_with_value('users', $value, $key)) {
                    return "Пользователь с таким $key уже существует";
                }
                break;
        }
        
        return false;
    }
}
