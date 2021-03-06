<?php
/**
 * RoomSpaceComponent::accessCheck()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * RoomSpaceComponent::accessCheck()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\RoomSpace\Test\Case\Controller\Component\RoomSpaceComponent
 */
class RoomSpaceComponentAccessCheckTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array();

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'room_space';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//テストプラグインのロード
		NetCommonsCakeTestCase::loadTestPlugin($this, 'RoomSpace', 'TestRoomSpace');
		//テストコントローラ生成
		$this->generateNc('TestRoomSpace.TestRoomSpaceComponent');
		//ログイン
		TestAuthGeneral::login($this);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		//ログアウト
		TestAuthGeneral::logout($this);

		parent::tearDown();
	}

/**
 * accessCheck()のテスト
 *
 * @return void
 */
	public function testAccessCheck() {
		//テストアクション実行
		$this->_testGetAction('/test_room_space/test_room_space_component/index',
				array('method' => 'assertNotEmpty'), null, 'view');
		$pattern = '/' . preg_quote('Controller/Component/TestRoomSpaceComponent', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		//テストデータ
		Current::$current = Hash::insert(Current::$current, 'RolesRoomsUser.id', '1');
		Current::$current = Hash::insert(Current::$current, 'RolesRoomsUser.user_id', '1');

		//テスト実行
		$result = $this->controller->RoomSpace->accessCheck($this->controller);

		//チェック
		$this->assertTrue($result);
	}

/**
 * accessCheck()のテスト
 * [他人(RolesRoomsUser.user_idが異なる)]
 *
 * @return void
 */
	public function testAccessCheckOtherUserId() {
		//テストアクション実行
		$this->_testGetAction('/test_room_space/test_room_space_component/index',
				array('method' => 'assertNotEmpty'), null, 'view');
		$pattern = '/' . preg_quote('Controller/Component/TestRoomSpaceComponent', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		//テストデータ
		$this->_mockForReturnTrue('Rooms.RolesRoomsUser', 'saveAccessed', 0);
		Current::$current = Hash::insert(Current::$current, 'RolesRoomsUser.id', '1');
		Current::$current = Hash::insert(Current::$current, 'RolesRoomsUser.user_id', '2');

		//テスト実行
		$result = $this->controller->RoomSpace->accessCheck($this->controller);

		//チェック
		$this->assertFalse($result);
	}

/**
 * accessCheck()のテスト
 * [他人(RolesRoomsUser.user_idなし)]
 *
 * @return void
 */
	public function testIndexWORolesRoomsUserId() {
		//テストアクション実行
		$this->_testGetAction('/test_room_space/test_room_space_component/index',
				array('method' => 'assertNotEmpty'), null, 'view');
		$pattern = '/' . preg_quote('Controller/Component/TestRoomSpaceComponent', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		//テストデータ
		$this->_mockForReturnTrue('Rooms.RolesRoomsUser', 'saveAccessed', 0);
		Current::$current = Hash::insert(Current::$current, 'RolesRoomsUser.id', '1');
		Current::$current = Hash::insert(Current::$current, 'RolesRoomsUser.user_id', null);

		//テスト実行
		$result = $this->controller->RoomSpace->accessCheck($this->controller);

		//チェック
		$this->assertFalse($result);
	}

}
