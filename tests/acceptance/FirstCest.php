<?php 

namespace App\Tests;

use App\Tests\AcceptanceTester;

class FirstCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function successfullLogInTest(AcceptanceTester $I) {
       	$I->amOnUrl('http://127.0.0.1:8000/#/signin');
       	$I->see('Вход');
       	$I->see('email');
       	$I->fillField('email', '123@123.com');
       	$I->see('Пароль');
       	$I->fillField('password', '123');
       	$I->click('Войти');

       	usleep(250000);

       	$I->dontSeeLink('Вход');
       	$I->dontSeeInCurrentUrl('/signin');
    }

    public function contentTest(AcceptanceTester $I) {
       	$I->amOnUrl('http://127.0.0.1:8000/#/index');
       	$I->see('Выход');
       	$I->see('Список авторов');
       	$I->see('Редактировать автора');
       	$I->click('Список книг');
       	$I->see('Книги автора');
       	$I->see('Добавить книгу');
    }

    public function actionsTest(AcceptanceTester $I) {
       	$I->amOnUrl('http://127.0.0.1:8000/#/index');
       	$I->see('Выход');
       	$I->click('Выход');

       	usleep(250000);

       	$I->see('Вход');
       	$I->click('Вход');
       	$I->fillField('email', '123@123.com');
       	$I->fillField('password', '123');
       	$I->click('Войти');

       	usleep(250000);

       	$I->see('Список авторов');
       	$I->click('Добавить автора');
       	$I->seeInCurrentUrl('/new');

       	usleep(250000);

       	$I->see('Добавить нового автора');
       	$I->see('Имя');
       	$I->see('Фамилия');
    }

    public function logOutTest(AcceptanceTester $I) {
       	$I->amOnUrl('http://127.0.0.1:8000/#/index');
       	$I->see('Выход');
       	$I->click('Выход');

       	usleep(250000);

       	$I->see('Вход');
       	$I->see('Регистрация');
    }

}
