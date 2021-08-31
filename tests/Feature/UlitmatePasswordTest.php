<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\UlitmatePassword;


class UlitmatePasswordTest extends TestCase
{

    /**
     * @testdox 測試$ulitmatePassword->playerGuessNumber方法, 若input值是在$this->min, $this->max間的數字, 則回傳input值
     */
    public function test_player_guess_number_retrun_input(){

        // Arrange
        $play_number = 2;
        $min_number = 2;
        $input = 20;
        $expected = 20;
        $ulitmatePassword = new UlitmatePassword($play_number, $min_number);

        // Act
        $actual = $ulitmatePassword->playerGuessNumber($input);
        
        // Assert
        $this->assertSame($expected, $actual);
    }

    /**
     * @testdox 測試$ulitmatePassword->playerGuessNumber方法, 若input值不在$this->min, $this->max間的數字, 則回傳0
     */
    public function test_player_guess_number_retrun_0(){

        // Arrange
        $play_number = 2;
        $min_number = 2;
        $input = 101;
        $expected = 0;
        $ulitmatePassword = new UlitmatePassword($play_number, $min_number);

        // Act
        $actual = $ulitmatePassword->playerGuessNumber($input);
        
        // Assert
        $this->assertSame($expected, $actual);
    }

    /**
     * @testdox 測試$ulitmatePassword->getNextPlayer方法, 若$this->round_now_who!=&this->player_number 則$this->round_now_who++
     */
    public function test_get_next_player_not_the_last(){

        // Arrange
        $play_number = 2;
        $min_number = 2;
        $ulitmatePassword = new UlitmatePassword($play_number, $min_number);
        $ulitmatePassword->setRoundNowWho(0);
        $expected = 1;

        // Act
        $ulitmatePassword->getNextPlayer();
        $actual = $ulitmatePassword->getRoundNowWho();
        // Assert
        $this->assertSame($expected, $actual);

    }

    /**
     * @testdox 測試$ulitmatePassword->getNextPlayer方法, 若$this->round_now_who==&this->player_number 則$this->round_now_who=0
     */
    public function test_get_next_player_the_last(){

        // Arrange
        $play_number = 2;
        $min_number = 2;
        $ulitmatePassword = new UlitmatePassword($play_number, $min_number);
        $ulitmatePassword->setRoundNowWho(1);
        $expected = 0;

        // Act
        $ulitmatePassword->getNextPlayer();
        $actual = $ulitmatePassword->getRoundNowWho();
        // Assert
        $this->assertSame($expected, $actual);


    }

    /**
     * @testdox 測試$ulitmatePassword->getMin方法, 會回傳$this->min
     */
    public function test_get_min(){
        // Arrange
        $play_number = 2;
        $min_number = 2;
        $ulitmatePassword = new UlitmatePassword($play_number, $min_number);
        $expected = 1;
        // Act
        $actual = $ulitmatePassword->getMin();
        // Assert
        $this->assertSame($expected, $actual);
    }

    /**
     * @testdox 測試$ulitmatePassword->getMax方法, 會回傳$this->max
     */
    public function test_get_max(){
        // Arrange
        $play_number = 2;
        $min_number = 2;
        $ulitmatePassword = new UlitmatePassword($play_number, $min_number);
        $expected = 100;
        // Act
        $actual = $ulitmatePassword->getMax();
        // Assert
        $this->assertSame($expected, $actual);
    }

    /**
     * @testdox 測試$ulitmatePassword->setAnswer方法, 若設定值在$this->min, $this->max間的數字, 則修改$this->answer的值
     */
    public function test_set_answer_in_range(){
        
        // Arrange
        $play_number = 2;
        $min_number = 2;
        $ulitmatePassword = new UlitmatePassword($play_number, $min_number);
        $answer = 101;
        $expected = $ulitmatePassword->getAnswer();
        // Act
        $ulitmatePassword->setAnswer($answer);
        $actual = $ulitmatePassword->getAnswer();
        // Assert
        $this->assertSame($expected, $actual);
    }

    /**
     * @testdox 測試$ulitmatePassword->setAnswer方法, 若設定值不在$this->min, $this->max間的數字, 則直接return
     */
    public function test_set_answer_out_of_range(){
        
        // Arrange
        $play_number = 2;
        $min_number = 2;
        $ulitmatePassword = new UlitmatePassword($play_number, $min_number);
        $answer = 101;
        $expected = $ulitmatePassword->getAnswer();
        // Act
        $ulitmatePassword->setAnswer($answer);
        $actual = $ulitmatePassword->getAnswer();
        // Assert
        $this->assertSame($expected, $actual);
    }

    /**
     * @testdox 測試$ulitmatePassword->setRoundNowWho方法, 若設定值在0, $this->player_number-1間的數字, 則修改$this->round_now_who的值
     */
    public function test_set_round_now_who_in_range(){
        // Arrange
        $play_number = 2;
        $min_number = 2;
        $ulitmatePassword = new UlitmatePassword($play_number, $min_number);
        $expected = $ulitmatePassword->getRoundNowWho();
        // Act
        $ulitmatePassword->setRoundNowWho(3);
        $actual = $ulitmatePassword->getRoundNowWho();
        // Assert
        $this->assertSame($expected, $actual);
        // Arrange
        $play_number = 2;
        $min_number = 2;
        $ulitmatePassword = new UlitmatePassword($play_number, $min_number);
        $expected = 1;
        // Act
        $ulitmatePassword->setRoundNowWho(1);
        $actual = $ulitmatePassword->getRoundNowWho();
        // Assert
        $this->assertSame($expected, $actual);
    }

    /**
     * @testdox 測試$ulitmatePassword->setRoundNowWho方法, 若設定值不在0, $this->player_number-1間的數字, 則直接return
     */
    public function test_set_round_now_who_out_of_range(){
        // Arrange
        $play_number = 2;
        $min_number = 2;
        $ulitmatePassword = new UlitmatePassword($play_number, $min_number);
        $expected = $ulitmatePassword->getRoundNowWho();
        // Act
        $ulitmatePassword->setRoundNowWho(3);
        $actual = $ulitmatePassword->getRoundNowWho();
        // Assert
        $this->assertSame($expected, $actual);
        // Arrange
        $play_number = 2;
        $min_number = 2;
        $ulitmatePassword = new UlitmatePassword($play_number, $min_number);
        $expected = 1;
        // Act
        $ulitmatePassword->setRoundNowWho(1);
        $actual = $ulitmatePassword->getRoundNowWho();
        // Assert
        $this->assertSame($expected, $actual);
    }

    /**
     * @testdox 測試$ulitmatePassword->getAnswer方法, 回傳$this->answer
     */
    public function test_get_answer(){
        // Arrange
        $play_number = 2;
        $min_number = 2;
        $ulitmatePassword = new UlitmatePassword($play_number, $min_number);
        $answer = 50;
        $expected = 50;
        // Act
        $ulitmatePassword->setAnswer($answer);
        $actual = $ulitmatePassword->getAnswer();
        // Assert
        $this->assertSame($expected, $actual);
    }
    
    /**
     * @testdox 測試$ulitmatePassword->getRecountMinAndMax, 若猜的值大於答案, 則設定$this->min = 猜的值
     */
    public function test_recount_min_and_max_change_min(){
        // Arrange
        $play_number = 2;
        $min_number = 2;
        $guess = 30;
        $ulitmatePassword = new UlitmatePassword($play_number, $min_number);
        $ulitmatePassword->setAnswer(50);
        $expected_min = 30;
        $expected_max = 100;
        // Act
        $ulitmatePassword->recountMinAndMax($guess);
        $actual_min = $ulitmatePassword->getMin();
        $actual_max = $ulitmatePassword->getMax();
        // Assert
        $this->assertSame($expected_min, $actual_min);
        $this->assertSame($expected_max, $actual_max);

    }

    /**
     * @testdox 測試$ulitmatePassword->getRecountMinAndMax, 若猜的值小於答案, 則設定$this->max = 猜的值
     */
    public function test_recount_min_and_max_change_max(){

        // Arrange
        $play_number = 2;
        $min_number = 2;
        $guess = 60;
        $ulitmatePassword = new UlitmatePassword($play_number, $min_number);
        $ulitmatePassword->setAnswer(50);
        $expected_min = 1;
        $expected_max = 60;
        // Act
        $ulitmatePassword->recountMinAndMax($guess);
        $actual_min = $ulitmatePassword->getMin();
        $actual_max = $ulitmatePassword->getMax();
        // Assert
        $this->assertSame($expected_min, $actual_min);
        $this->assertSame($expected_max, $actual_max);


    }
}
