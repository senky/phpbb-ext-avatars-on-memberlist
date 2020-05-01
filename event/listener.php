<?php
/**
 *
 * Avatars on Memberlist. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2020, Jakub Senko
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace senky\avatarsonmemberlist\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	public static function getSubscribedEvents()
	{
		return [
			'core.memberlist_team_modify_query'					=> 'fetch_user_avatar_team_page',
			'core.memberlist_team_modify_template_vars'	=> 'avatar_on_team_page',
		];
	}

	protected $template;
	public function __construct(\phpbb\template\template $template)
	{
		$this->template = $template;
	}

	public function fetch_user_avatar_team_page($event)
	{
		$sql_ary = $event['sql_ary'];
		$sql_ary['SELECT'] .= ', u.user_avatar, u.user_avatar_width, u.user_avatar_height, u.user_avatar_type';
		$event['sql_ary'] = $sql_ary;
	}

	public function avatar_on_team_page($event)
	{
		$template_vars = $event['template_vars'];
		$template_vars['AVATAR_IMG'] = phpbb_get_user_avatar($event['row']);
		$event['template_vars'] = $template_vars;
	}
}
