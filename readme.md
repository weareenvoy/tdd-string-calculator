## String Calculator

The string calculator is another TDD kata. The overarching concept is that a string of numbers is sent to the class and those numbers are summed.

[Read Ahead](http://osherove.com/tdd-kata-1/)

### Tech Used

**Technology, Techniques, etc.**

* PHP
* [PHPUnit 6.0](https://github.com/sebastianbergmann/phpunit)


* Red-Green-Refactor
* Arrange, Act, Assert

### Description of each step in the process

There isn’t so much of an explanation in this process, mostly because I’m learning this one as I go. What I do know is this:

We have a class `StringCalculator`, and we’re writing up the tests for the function `StringCalculator::add(string $numbers)`. We’ll get more detailed specs as we go!

#### Test #1 -- Summing an Empty String

Follow along with the code completely by following the commits in `test/1-sum-empty-string`.

Our first task is to prove our method can sum from 0 to 2 numbers in a given string. No numbers means we return 0.

Let’s write the first test!

```php
<?php

class StringCalculatorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function sums_an_empty_string()
    {
        $calc = new StringCalculator;
        
        $result = $calc->add('');
        
        self::assertSame(0, $result);
    }
}
```

If you followed along with the Bowling Kata, you know where this is going. Let’s run the test!

```
Error: Class 'StringCalculator' not found
```

Surprise! Let’s create the class and see what happens next.

```
Error: Call to undefined method StringCalculator::add()
```

Add the empty function and re-run!

```
Failed asserting that null is identical to 0.
```

> If you did follow the Bowling Kata example first, you will remember that we used `TestCase::assertEquals()`
> instead of `TestCase::assertSame()`. While things will pan out similarly in this kata, (i.e. we could just
> use `assertEquals()` and fix the issue after the next test is run) let’s use `assertSame()` and see how it
> all plays out!

Ok, let’s have `StringCalculator::add()` return 0 and see if we can’t get this test to pass with that.

Success!

> Once again, you’ll notice that we didn’t truly flesh out the functionality that will eventually be expected
> for this function. That’s the point! We’re only meeting one requirement. There’s no reason to make the code
> any more verbose than what our requirements explicitly expect. Writing any more code is just asking for
> unused (and potentially problematic) code.

#### Test #2 -- Sum String With One Number

Follow along with the code completely by following the commits in `test/2-sum-string-with-one-number`.

Ok, this one seems a bit silly at first glance, I know. This test meets an important goal that we couldn’t meet with our first test. This will force us to write some real code. Let’s go!

```php
<?php

class StringCalculatorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function sums_string_with_one_number()
    {
        $calc = new StringCalculator;
        
        $result = $calc->add('1');
        
        self::assertSame(1, $result);
    }
}
```

That looks pretty satisfactory, so let’s run the tests!

```
Failed asserting that 0 is identical to 1.
```

As expected, it fails. Let’s see what we can do to make it work. What if we simply cast our input as an `int` and return it?

Passing!

> Yeah, so about that important goal this was supposed to meet. You might be wondering what that was.
> This test made it so that one number does work regardless of what the number is. PHP coerces an 
> empty string to 0, which means we don’t have to do that much work for this one.

#### Interlude #1 -- Refactoring

This refactoring step will be pretty simple, as there really isn’t too much code just yet. Let’s quickly extract the creation of `StringCalculator` into a method so it can be easily recreated in case our dependencies change.

For more details, read the Bowling Kata Interlude #1. Since you’re now an expert at this kind of refactoring, we’ll skip past the nitty gritty and just make it working. (PhpStorm makes this super easy because the IDE refactors for you, and won’t break your code unless you select incorrectly. Bonus points!)

As long as we’re still green, we’re good! Onto the next test.

#### Test #3 -- Sum String With Two Numbers

Follow along with the code completely by following the commits in `test/3-sum-string-with-two-numbers`.

Alright, the real testing starts now. Let’s write up our next test to get two numbers sent into our calculator.

```php
<?php

class StringCalculatorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function sums_string_with_two_numbers()
    {
        $calc = $this->createCalculator();
        
        $result = $calc->add('1,2');
        
        self::assertSame(3, $result);
    }
}
```

As expected, this test fails, but maybe not exactly how you’d think...

```
Failed asserting that 1 is identical to 3.
```

> When PHP coerces a string to an int, it finds the first reasonable value. In this case, that value
> is 1, so it returns 1 instead of throwing some other error. ¯\_(ツ)_/¯
