<?php

namespace App\Interfaces;

interface TeamModelConstantInterface extends ModelCommonConstant
{
    public const TABLE_NAME = 'teams';
    public const ID = 'id';
    public const NAME = 'name';
    public const SLUG = 'slug';
    public const IS_WINNER = 'is_winner';
    public const STEP = 'step_on_which_is_winner_updated';
}
