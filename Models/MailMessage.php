<?php

namespace Models {

    use Core\AbstractEntity;
    use Helpers\Validator;
    use Interfaces\EntityInterface;
    use Models\Table\User;
    use Traits\Instance;

    /**
     * @property string $subject
     * @property string $body
     * @property string $receiverEmail
     * @property string $receiverName
     */
    class MailMessage extends AbstractEntity implements EntityInterface {

        protected $data;

        protected static
            $properties = [
                'subject'       => [self::TYPE_STRING, [Validator::MIN => 1]],
                'body'          => [self::TYPE_STRING, [Validator::MIN => 1]],
                'receiverEmail' => [self::TYPE_STRING, [Validator::MIN => 5, Validator::REGEX => Validator::EMAIL, Validator::MAX => 64]],
                'receiverName'  => [self::TYPE_STRING, [Validator::MIN => 2]],
            ];
    }

}
