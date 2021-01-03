<?php

namespace App\Models;

use App\Core\AbstractEntity;
use App\Helpers\Validator;
use App\Models\Constant\UserStatus;
use App\Models\Table\User;
use App\Traits\Instance;

/**
 * @property User user
 * @property bool is_authorized
 * @property int  session_id
 */
class CurrentUser extends AbstractEntity {
    use Instance;

    protected static array
        $properties = [
            'user'          => [self::TYPE_DTO,  User::class],
            'is_authorized' => [self::TYPE_BOOL, []],
            'session_id'    => [self::TYPE_INT,  [Validator::MIN => 1]],
        ];

    public function getUserAvatar() : ?string {
        $path = '/assets/%s/%s.' . (WEBP ? 'webp' : 'jpg');
        if (!$this->is_authorized) {
            return sprintf($path, 'img/avatars', ($this->session_id-1)%30+1);
        }
        if ($this->user->has_photo) {
            return sprintf($path, 'user', $this->user->id);
        }
        return sprintf($path, 'img/avatars', ($this->user->id-1)%30+1);
    }

    public function getId() : ?int {
        return $this->is_authorized ? $this->user->id : null;
    }

    public function getStatusId() : ?int {
        return $this->is_authorized ? $this->user->status_id : null;
    }

    public function isAdmin(): bool {
        return $this->getStatusId() === UserStatus::ADMIN;
    }
}
