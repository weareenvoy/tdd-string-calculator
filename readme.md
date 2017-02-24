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

Follow along with the code completely by following the commits in `refactor/part-2`.

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

Let’s write some real code to make this work. As we can tell from our test, we’re using `,` as a string delimiter, so maybe the first thing we do here is split our string into an array of numbers which we can sum. PHP has some pretty useful array functions to make this a ridiculously simple test to complete, but feel free to use whatever methodology you’d like.

Passing!

#### Interlude #2 -- Refactoring?

At this point, we don’t actually have all that much to refactor, so there’s no need to do this section.

> If you didn't use the built-in `array_sum()` PHP function, maybe this is a good time to refactor to simplify you code.
> Remember, readability is an important goal!

#### Test #4 -- Sum String With Many Numbers

Follow along with the code completely by following the commits in `test/4-sum-string-with-many-numbers`.

Ok, so we’ve proven that our unit can handle 0 - 2 numbers. Let’s write up a test that sets up a few cases of indeterminate numbers to see how things work.

```php
<?php

class StringCalculatorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function sums_string_with_many_numbers()
    {
        $calc = $this->createCalculator();
        
        $result1 = $calc->add('1,2,3,4,5'); // 15
        $result2 = $calc->add('4,9,16,25,36,49,64,81,100'); // 384
        
        self::assertSame(15, $result1);
        self::assertSame(384, $result2);
    }
}
```

If you wrote `StringCalculator::add()` as mentioned in the sidebar above, this test just passes! If not, make that change and everything should pass!

#### Test #5 -- Handle Newline and Comma Delimiters

Follow along with the code completely by following the commits in `test/5-handle-newline-and-comma-delimiters`.

The last few tests have been pretty easy to handle, so let’s throw a wrench in everything here. We used a comma previously as a delimiter, and that’s a good starting point. Now we need to add the ability to handle newlines as a delimiter alongside of commas.

What does this mean for potential string values? Here are a list of values that would be considered valid within the new rules (remember, all the previous rules still apply!):

* 1\n2,3
* 2,4,6\n8\n10\n12
* 3\n6,9\n12,15\n18
* 4\n16\n64\n256\n1024

Luckily, our previous test is pretty similar to this setup, so let’s just write the next one!

```php
<?php

class StringCalculatorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function sums_string_with_comma_and_newline_delimiters()
    {
        $calc = $this->createCalculator();
        
        $result1 = $calc->add("1\n2,3");
        $result2 = $calc->add("2,4,6\n8\n10\n12");
        $result3 = $calc->add("3\n6,9\n12,15\n18");
        $result4 = $calc->add("4\n16\n64\n256\n1024");
        
        self::assertSame(6, $result1);
        self::assertSame(42, $result2);
        self::assertSame(63, $result3);
        self::assertSame(1364, $result4);
    }
}
```

> You may notice that we’re now using " instead of '. By adding \n into the string, we need PHP to interpolate it correctly. ' doesn’t meet those requirements, so we need to switch.

That looks pretty good to me, so let’s run the tests and see what happens!

```
Failed asserting 4 is identical to 6.
```

Hmm, that’s slightly different than anticipated... Based on the line where PHPUnit tells us the failure occurred, it’s on this line:

```php
<?php

self::assertSame(6, $result1);
```

Huh. Well, let’s take a look and see what’s happening. Remember, PHP grabs the first number it can find in a string and uses that as the value, regardless of the rest of the string (at least in our cases here).

`$result1` is using the test string `"1\n2,3"`. Based on our code for `StringCalculator::add()`, this would split on the comma, giving us two values: `"1\n2"` and `"3"`. When we cast each to integers, we get `1` and `3`. Ok, now it makes sense how we were seeing `4` instead of `6`.

Since we’re solving for one test still, we can look at this a bit more high level than we have with previous tests. We have 4 assertions to make true, so we can skip past the tedious work to get a better implementation more quickly.

We have a few options on how we can do this, so let’s brainstorm quickly and run through them before writing any tests:

* loop through every character, determining if it’s a number, comma, or newline
*`explode` on a comma as we are, then walk the resulting array with an `explode` on newlines
* replace all newlines with commas, then explode the string

That’s enough methods for the time being. Time to evaluate each one and see which one we like the best.

##### Looping through every character

Right off the bat, this just sounds like it could be covered by some language constructs or built-in functions. It’s definitely a viable strategy and could be done as a fun exercise. Since we’re using PHP, let’s take advantage of the tools given by the language and try for a different option.

##### Walking an array

This method is pretty good. We know there are only two delimiters allowed, so we could keep pretty efficient for short lists. Since there are only two delimiters, we wouldn’t have a case where a stack overflow could happen. This is definitely an option, but it may not be as readable as we would desire for this kind of thing.

##### Replace newlines with commas

Basically, here we would take the string, do a quick replace, and continue as we have been. This really does sound like a pretty quick and effective way to get this requirement completed.

Let’s run with option 3 for now, and see how it goes. We’ll update `StringCalculator::add()` to do that kind of string replace.

Once that’s done, run the tests again! Passing, and it really didn’t take that much work. Fantastic!

#### Test #6 -- Handle Defined Delimiter

Follow along with the code completely by following the commits in `test/6-handle-defined-delimiter`.

Once again, we don’t have anything to really refactor. That last test was resolved by a quick one-line modification, so we’re sitting pretty. Let’s figure out what the next requirement is.

Now, our `StringCalculator` needs to be able to handle a dynamically defined delimiter. The format for these strings is as follows:

```
//[delimiter]\n[numbers...]
```

For example:

```
//;\n1;2;3,4\n5
```

... would make `;` a valid delimiter, as well as the previously used `,` and `\n`. That being said, the following:

```
//;ope\n1;2o3
```

is **not** a valid string, because delimiters must be a single character, and because we are only supporting a single delimiter with this test.

Let’s write it!

```php
<?php

class StringCalculatorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function sums_string_with_custom_delimiter()
     {
         $calc = $this->createCalculator();
        
         $result = $calc->add("//;\n2;4;6,8\n10\n12");
        
         self::assertSame(42, $result);
     }
}
```

Looks like that test would cover our whole case here. We’re defining a new delimiter, using said delimiter, and using the previous delimiters as well.

> Note: Be aware that this test does not supersede any of the previous tests! We still have to
> support the old format without a custom delimiter, which is what the previous tests will be
> accomplishing for us.

Alright, time to run it and see what happens!

```
Failed asserting that 32 is identical to 42.
```

As expected, this test is failing. Looks like we’ll need to do some string parsing to check whether or not we have a new delimiter, and then after that, we can process the rest of the numbers as we did previously.

Here’s the process that makes the most to me:

    check beginning of the line to see if it matches //
    if so, determine new delimiter and pop off everything before first newline
    process as before, using new delimiter along with the original two

Simplicity is key here. There’s absolutely an opportunity to use a regular expression here, but a regular expression will compromise readability. That could theoretically be the end result, but let’s stay away from them for the time being.

Let’s rebuild `StringCalculator::add()` to fit these new requirements while not breaking our old tests.

Tests like these sometimes require some minor refactoring while doing some rewriting of the setup. We can get away with changing very little of our current implementation, while adding the new functionality. First, let’s pull out `"\n"` into an array that we’ll send into `str_replace`. Then, let’s use the logic from above to check if there is a new delimiter specified, get the delimiter, and add it onto our newly created array of allowed delimiters.

After doing all of that, run the tests again and you should see it passing!

> This action works really well in PHP because most of the string manipulation functions allow for
> individual strings or arrays of multiple strings as a pattern or a replacement. Also, by just adding
> a quick check above our initial action, we’re almost guaranteeing that the previous tests work
> without a hitch.

> In running through most of these tests (and this one for sure in particular), you may have wondered
> why there’s no focus on trying to validate the input. Normally, that would be part of the tests we
> would need to write, for sure, but for the purposes of the kata, we will assume the input being sent
> is pre-validated.
