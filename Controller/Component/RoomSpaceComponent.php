<?php
/**
 * RoomSpace Component
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Component', 'Controller');

/**
 * RoomSpace Component
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\RoomSpace\Controller\Component
 */
class RoomSpaceComponent extends Component {

/**
 * アクセスチェック
 *
 * @param Controller $controller Controller with components to startup
 * @return bool
 */
	public function accessCheck(Controller $controller) {
		CakeLog::debug('RoomSpaceComponent::accessCheck');

		return;
	}
}
