<?php


namespace App\Utils;


use Silber\Bouncer\BouncerFacade;

/**
 * @method static boolean can(string $permission, string $subject) ex. if(Bouncer::can('manage', Worker::class))
 * @method static Bouncer allow(string $permission)
 * @method static Bouncer forbid(string $permission)
 * @method everything()
 * @method toManage(string $classQualifier)
 */
class Bouncer extends BouncerFacade
{

}
