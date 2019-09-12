<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TasksSeederUA extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            "Ромби та трикутники",
            "Чи вірно розташовані дужки?",
            "Роз'єднуй та сортуй!",
            "Solve Me First",
            "Номери автомобілів",
            "Стріли",
            "Панграма",
            "Вивчення Марсу",
            "Ромби та п'ятикутники",
            "Люди та коти",
            "Третій зайвий",
            "Визначення",
            "Арифметика",
            "Золота середина",
            "Віднімання",
            "По іншу сторону нуля",
            "Мега-зріст",
            "Мега-спад",
            "Копіювання",
            "Серед нулів",
            "Я - більше",
            "Ближче всіх",
            "Не такий, як усі",
            "Парне-непарне",
            "Границі",
        ];

        $descriptions = [
            [
                'problem' => 'Порахувати кількість кутів в N трикутників і К ромбів.',
                'note' => 'N і K передаються параметрами функції і 0 < N, K < 10000. Функція повертає сумарну кількість кутів.',
                'example' => [
                    'input' => '1, 1',
                    'output' => '7'
                ]
            ],
            [
                'problem' => 'Визначити правильність розташування круглих дужок в математичному виразі.',
                'note' => 'Параметром функції передається рядок з математичним виразом. Функція повинна повернути 100, якщо дужки розставлені правильно, в іншому випадку - кількість зайвих дужок.',
                'example' => [
                    'input' => '(2  * (3 + 5)) / 12 + 14)',
                    'output' => '1'
                ]
            ],
            [
                'problem' => 'Дан масив цілих чисел, який передається параметром функції. Потрібно розмістити елементи в масиві таким чином: спочатку масиву повинні бути непарні числа, відсортовані по зростанню, після них - парні, також відсортовані по зростанню.',
                'note' => 'Функція параметром приймає масив і повертає відсортований масив.',
                'example' => [
                    'input' => '[1, 8, 3, 4, 5, 2, 7, 6, 9]',
                    'output' => '[1, 3, 5, 7, 9, 2, 4, 6, 8]'
                ]
            ],
            [
                'problem' => 'Це перше завдання, мета якого познайомити вас з сервісом і відправкою завдань. Вам потрібно порахувати суму 2-х чисел. У функцію (метод) передається 2 значення a і b, функція повертає суму цих значень (-1000 < a, b < 1000)',
                'note' => 'У цьому завданні ми надаємо вам робочий код, його не обов\'язково міняти. Так, ми вже написали все за вас, відправляйте :). В цьому і наступних завданнях вам не потрібно писати всю програму, тільки функцію / метод, яка приймає на вхід задані параметри, обробляє їх і повертає (return) потрібні значення, все інше вже написано нами. Бібліотеки, потрібні для виконання завдання також вже підключені. Програма повинна бути довжиною менше 4500 символів.',
                'example' => [
                    'input' => '',
                    'output' => ''
                ]
            ],
            [
                'problem' => 'Основна частина державного реєстраційного номера складається з 6 символів: трьох літер і трьох цифр. Спочатку йде літера, потім 3 цифри і ще 2 літери закінчують запис.  Можуть використовуватися будь-які цифри від 0 до 9, а в якості літер лише наступні символи: A, B, C, E, H, K, M, O, P, T, X, Y. Наприклад, «P204BT» - правильний номер, а «X182YZ» і «ABC216» - ні. Ваше завдання - визначити, які з номерів відповідають прийнятому стандарту, а які ні.',
                'note' => 'Функція приймає рядок - автомобільний номер. Функція повертає 100, якщо номер правильний, або кількість літер в номері, якщо він не відповідає стандарту.',
                'example' => [
                    'input' => 'P204BT',
                    'output' => '100'
                ]
            ],
            [
                'problem' => 'Задана послідовність, що складається тільки з символів ">", "<" та "-". Потрібно знайти кількість стріл, які заховані в цій послідовності. Стріла - це рядок, який має вигляд ">>->" або "<-<<".',
                'note' => 'Для функції параметром передається рядок, що складається з символів ">", "<" та "-" (без пробілів). Рядок складається не більше ніж з 250 символів. Функція повертає кількість знайдених стріл.',
                'example' => [
                    'input' => '<<<<>>--><--<<',
                    'output' => '2'
                ]
            ],
            [
                'problem' => 'Вам даний рядок, що складається з латинських літер. Рядок називається панграмою, якщо він містить кожну з 26 латинських літер хоча б раз. Визначте чи є рядок панграмою.',
                'note' => 'Функція приймає параметром рядок. Функція повинна повернути 100, якщо рядок є панграмою, в іншому випадку - кількість відсутніх літер (щоб рядок вважався панграмою).',
                'example' => [
                    'input' => 'Wepromptlyjudgedantiqueivorybucklesforthenextprize',
                    'output' => '100'
                ]
            ],
            [
                'problem' => 'Корабель Воллі зазнав аварії на Марсі і шле сигнал SOS на землю. Космічна радіація змінила деякі літери в посланні.',
                'note' => 'Функція параметром приймає рядок. Так як вихідне повідомлення складається з повторення фрази SOS, то довжина рядка кратна 3. Функція повинна повернути кількість літер, змінених радіацією.',
                'example' => [
                    'input' => 'SOSSPSSQSSOR',
                    'output' => '3'
                ]
            ],
            [
                'problem' => 'Порахувати кількість кутів у N трикутників и К п\'ятикутників.',
                'note' => ' N і K передаються параметрами функції і 0 < N, K < 10000. Функція повертає сумарну кількість кутів.',
                'example' => [
                    'input' => '1, 1',
                    'output' => '8'
                ]
            ],
            [
                'problem' => 'Порахувати кількість очей у N людей та К котів.',
                'note' => 'N і K передаються параметрами функції і 0 < N, K < 10000. Функція повертає сумарну кількість очей.',
                'example' => [
                    'input' => '1, 1',
                    'output' => '4'
                ]
            ],
            [
                'problem' => 'На вхід функції передається три цілих числа, до того ж два з них однакові. Треба повернути те, яке відрізняється від інших або ж повернути -1 якщо всі три рівні між собою.',
                'note' => '',
                'example' => [
                    'input' => '1, 1, 3',
                    'output' => '3'
                ]
            ],
            [
                'problem' => 'На вхід функції передається три цілих числа. Треба повернути 100, якщо вони всі відрізняються один від одного, найбільше серед них, якщо два з них рівні, або -1, якщо вони всі рівні один одному.',
                'note' => '',
                'example' => [
                    'input' => '1, 2, 3',
                    'output' => '100'
                ]
            ],
            [
                'problem' => 'На вхід функції передається два цілих числа. Треба повернути 100, якщо сума цих чисел дорівнює їх добутку. Треба повернути найбільше серед цих чисел, якщо сума або добуток цих чисел менше нуля. В інших випадках повернути -1.',
                'note' => '',
                'example' => [
                    'input' => '5, -3',
                    'output' => '5'
                ]
            ],
            [
                'problem' => 'На вхід функції передається три цілих числа. Потрібно повернути число, значення якого знаходиться між двома іншими. Якщо ж вони всі рівні між собою, то треба повернути -1.',
                'note' => '',
                'example' => [
                    'input' => '7, 4, 5',
                    'output' => '5'
                ]
            ],
            [
                'problem' => 'На вхід функції передається три числа. Треба віднімати від першого числа друге до тих пір, поки отриманий результат не стане меншим за третє число, і після цього потрібно повернути цей результат.',
                'note' => '',
                'example' => [
                    'input' => '20, 3, 10',
                    'output' => '8'
                ]
            ],
            [
                'problem' => 'На вхід функції передається два цілих числа. Треба до першого числа додати друге, потім відняти друге число помножене на саме себе. Це треба повторювати до тих пір (починаючи з додавання до отриманого результату другого числа), поки в результаті не отримаємо число < 0, і цей результат потрібно буде повернути.',
                'note' => 'Гарантується, що рано чи піздно результат стане < 0.',
                'example' => [
                    'input' => '20, 4',
                    'output' => '-4'
                ]
            ],
            [
                'problem' => 'На вхід функції передається одне число. Треба це число збільшувати у два рази до тих пір, поки воно не стане більше 1 000 000. Отримане число повернути з функції.',
                'note' => 'Гарантується, що рано чи піздно результат перевище 1 000 000.',
                'example' => [
                    'input' => '500 001',
                    'output' => '1 000 002'
                ]
            ],
            [
                'problem' => 'На вхід функції передається три цілих числа. Треба від першого числа відняти друге, після цього відняти друге-1, потім друге-2 ... і так кількість разів, рівну значенню третього числа. Результат повернути з функції.',
                'note' => 'Перше та друге число можуть бути < 0.',
                'example' => [
                    'input' => '20 5 3',
                    'output' => '8'
                ]
            ],
            [
                'problem' => 'На вхід функції передається два числа, до того ж перше - від 1 до 9. Треба повернути число, що складається з однакових цифр, рівних першому параметру, при цьому кількість цих цифр має дорівнювати другому параметру.',
                'note' => '',
                'example' => [
                    'input' => '2, 4',
                    'output' => '2222'
                ]
            ],
            [
                'problem' => 'На вхід функції приходить масив цілих чисел, а другим параметром - його розмір. Знайдіть в масиві перше число, яке оточене нулями. Якщо таке число не знайдено - поверніть -1, інакше поверніть індекс такого елемента.',
                'note' => '',
                'example' => [
                    'input' => '[0, 4, 0, 8], 4',
                    'output' => '1'
                ]
            ],
            [
                'problem' => 'На вхід функції приходить масив цілих чисел, а другим параметром - його розмір. Знайдіть в масиві кількість елементів, які більше ніж попередній елемент і поверніть це число з функції.',
                'note' => '',
                'example' => [
                    'input' => '[5, 2, 8, 9], 4',
                    'output' => '2'
                ]
            ],
            [
                'problem' => 'На вхід функції приходить масив цілих чисел, а другим параметром - його розмір. Знайдіть в масиві елемент який найбільш близький до 0, і поверніть індекс цього елемента.',
                'note' => '',
                'example' => [
                    'input' => '[5, 2, 8, 9], 4',
                    'output' => '1'
                ]
            ],
            [
                'problem' => 'На вхід функції приходить масив цілих чисел, а другим параметром - його розмір. Знайдіть у масиві єдиний елемент, який відрізняється від всіх інших, і поверніть індекс цього елемента.',
                'note' => '',
                'example' => [
                    'input' => '[5, 5, 8, 5], 4',
                    'output' => '2'
                ]
            ],
            [
                'problem' => 'На вхід функції приходить масив цілих чисел, а другим параметром - його розмір. Поміняйте в масиві місцями парні і наступні за ними (при рахунку) непарні елементи 0 і 1, 2 і 3, 4 і 5, і т.д. Якщо масив має непарну кількість елементів, то останній елемент не чіпайте. Потрібно повернути відсортований таким способом масив.',
                'note' => '',
                'example' => [
                    'input' => '[1, 4, 3, 2, 0], 5',
                    'output' => '[0, 4, 2, 3, 1]'
                ]
            ],
            [
                'problem' => 'На вхід функції приходить масив цілих чисел, а другим параметром - його розмір. Змініть масив таким чином: кожен елемент, який менше 0, замініть на 0, а кожен елемент, який більше 100 - замініть на 100. Поверніть змінений таким способом масив.',
                'note' => '',
                'example' => [
                    'input' => '[101, -8, 3, 4, -17], 5',
                    'output' => '[100, 0, 3, 4, 0]'
                ]
            ]
        ];

        $taskNumbers = [1, 5, 5, 0, 5, 5, 5, 5, 1, 1, 2, 2, 2, 2, 3, 3, 3, 3, 3, 4, 4, 4, 4, 4, 4];

        $jsWraps = [
            "process.stdin.resume();
var stdin = \"\";
process.stdin.on('data', function(chunk) {
    stdin += chunk;
});
 
process.stdin.on('end', function() {
    var array = stdin.split(' ');
 
    var triangleN = parseInt(array[0]);
    var rhombK = parseInt(array[1]);
 
    process.stdout.write(resolve(triangleN, rhombK).toString());
});
 
{{code}}",
            "process.stdin.resume();
var stdin = \"\";
process.stdin.on('data', function(chunk) {
    stdin += chunk;
});
process.stdin.on('end', function() {
    process.stdout.write(isBracketsPlacedCorrectly(stdin).toString());
});
 
{{code}}",
            "process.stdin.resume();
var stdin = \"\";
process.stdin.on('data', function(chunk) {
    stdin += chunk;
});
 
process.stdin.on('end', function() {
    var array = stdin.split(' ');
    var arraySize = array.splice(0, 1);
    for (var i = 0; i < arraySize; i++) {
        array[i] = parseInt(array[i]);
    }    
    separateAndSort(array);
    process.stdout.write('['+separateAndSort(array).toString()+']');
});
 
{{code}}
 ",
            "process.stdin.resume();
            var stdin = '';
            process.stdin.on('data', function(chunk){stdin += chunk;});
            process.stdin.on('end', function() { var array=stdin.split(' ');    
            var a = parseInt(array[0]);    
            var b = parseInt(array[1]);   
            {{code}}    
            console.log(sum(a,b));});",
            "process.stdin.resume();
var stdin = \"\";
process.stdin.on('data', function(chunk) {
    stdin += chunk;
});
process.stdin.on('end', function() {
    var array = stdin.split(' ');
    process.stdout.write(resolve(array[1]).toString());
});
 
{{code}}",
            "process.stdin.resume();
var stdin = \"\";
process.stdin.on('data', function(chunk) {
    stdin += chunk;
});
process.stdin.on('end', function() {
    var array = stdin.split(' ');
    process.stdout.write(resolve(array[1]).toString());
});
 
{{code}}",
            "process.stdin.resume();
var stdin = \"\";
process.stdin.on('data', function(chunk) {
    stdin += chunk;
});
process.stdin.on('end', function() {
    var array = stdin.split(' ');
    process.stdout.write(resolve(array[1].replace('\\n', '')).toString());
});
 
{{code}}",
            "process.stdin.resume();
var stdin = \"\";
process.stdin.on('data', function(chunk) {
    stdin += chunk;
});
process.stdin.on('end', function() {
    var array = stdin.split(' '); 
    process.stdout.write(resolve(array[1].replace('\\n', '')).toString());
});
 
{{code}}",
            "process.stdin.resume();
var stdin = \"\";
process.stdin.on('data', function(chunk) {
    stdin += chunk;
});
 
process.stdin.on('end', function() {
    var array = stdin.split(' ');
 
    var triangleN = parseInt(array[0]);
    var pentagonN = parseInt(array[1]);
 
    process.stdout.write(resolve(triangleN, pentagonN).toString());
});
 
{{code}}",
            "process.stdin.resume();
var stdin = \"\";
process.stdin.on('data', function(chunk) {
    stdin += chunk;
});
 
process.stdin.on('end', function() {
    var array = stdin.split(' ');
 
    var peopleN = parseInt(array[0]);
    var catsK = parseInt(array[1]);
 
    process.stdout.write(resolve(peopleN, catsK).toString());
});
 
{{code}}",
            "process.stdin.resume();
var stdin = \"\";
process.stdin.on('data', function(chunk) {
    stdin += chunk;
});
 
process.stdin.on('end', function() {
    var array = stdin.split(' ');
 
    var first = parseInt(array[0]);
    var second = parseInt(array[1]);
    var third = parseInt(array[2]);
 
    process.stdout.write(resolve(first, second, third).toString());
});
 
{{code}}",
            "process.stdin.resume();
var stdin = \"\";
process.stdin.on('data', function(chunk) {
    stdin += chunk;
});
 
process.stdin.on('end', function() {
    var array = stdin.split(' ');
 
    var first = parseInt(array[0]);
    var second = parseInt(array[1]);
    var third = parseInt(array[2]);
 
    process.stdout.write(resolve(first, second, third).toString());
});
 
{{code}}",
            "process.stdin.resume();
var stdin = \"\";
process.stdin.on('data', function(chunk) {
    stdin += chunk;
});
 
process.stdin.on('end', function() {
    var array = stdin.split(' ');
 
    var first = parseInt(array[0]);
    var second = parseInt(array[1]);
        process.stdout.write(resolve(first, second).toString());
});
 
{{code}}",
            "process.stdin.resume();
var stdin = \"\";
process.stdin.on('data', function(chunk) {
    stdin += chunk;
});
 
process.stdin.on('end', function() {
    var array = stdin.split(' ');
 
    var first = parseInt(array[0]);
    var second = parseInt(array[1]);
    var third = parseInt(array[2]);
 
    process.stdout.write(resolve(first, second, third).toString());
});
 
{{code}}",
            "process.stdin.resume();
var stdin = \"\";
process.stdin.on('data', function(chunk) {
    stdin += chunk;
});
 
process.stdin.on('end', function() {
    var array = stdin.split(' ');
 
    var first = parseInt(array[0]);
    var second = parseInt(array[1]);
    var third = parseInt(array[2]);
 
    process.stdout.write(resolve(first, second, third).toString());
});
 
{{code}}",
            "process.stdin.resume();
var stdin = \"\";
process.stdin.on('data', function(chunk) {
    stdin += chunk;
});
 
process.stdin.on('end', function() {
    var array = stdin.split(' ');
 
    var first = parseInt(array[0]);
    var second = parseInt(array[1]);
        process.stdout.write(resolve(first, second).toString());
});
 
{{code}}",
            "process.stdin.resume();
var stdin = \"\";
process.stdin.on('data', function(chunk) {
    stdin += chunk;
});
 
process.stdin.on('end', function() {
    var array = stdin.split(' ');
 
    var first = parseInt(array[0]);
            process.stdout.write(resolve(first).toString());
});
 
{{code}}",
            "process.stdin.resume();
var stdin = \"\";
process.stdin.on('data', function(chunk) {
    stdin += chunk;
});
 
process.stdin.on('end', function() {
    var array = stdin.split(' ');
 
    var first = parseInt(array[0]);
    var second = parseInt(array[1]);
    var third = parseInt(array[2]);
 
    process.stdout.write(resolve(first, second, third).toString());
});
 
{{code}}",
            "process.stdin.resume();
var stdin = \"\";
process.stdin.on('data', function(chunk) {
    stdin += chunk;
});
 
process.stdin.on('end', function() {
    var array = stdin.split(' ');
 
    var first = parseInt(array[0]);
    var second = parseInt(array[1]);
        process.stdout.write(resolve(first, second).toString());
});
 
{{code}}",
            "process.stdin.resume();
var stdin = \"\";
process.stdin.on('data', function(chunk) {
    stdin += chunk;
});
 
 
process.stdin.on('end', function() {
    var array = stdin.split(' ');
    var arraySize = array.splice(0, 1);
    for (var i = 0; i < arraySize; i++) {
        array[i] = parseInt(array[i]);
    }

process.stdout.write(resolve(array, arraySize).toString());
});    


{{code}}",
            "process.stdin.resume();
var stdin = \"\";
process.stdin.on('data', function(chunk) {
    stdin += chunk;
});
 
 
process.stdin.on('end', function() {
    var array = stdin.split(' ');
    var arraySize = array.splice(0, 1);
    for (var i = 0; i < arraySize; i++) {
        array[i] = parseInt(array[i]);
    }

process.stdout.write(resolve(array, arraySize).toString());
});    


{{code}}",
            "process.stdin.resume();
var stdin = \"\";
process.stdin.on('data', function(chunk) {
    stdin += chunk;
});
 
 
process.stdin.on('end', function() {
    var array = stdin.split(' ');
    var arraySize = array.splice(0, 1);
    for (var i = 0; i < arraySize; i++) {
        array[i] = parseInt(array[i]);
    }

process.stdout.write(resolve(array, arraySize).toString());
});    


{{code}}",
            "process.stdin.resume();
var stdin = \"\";
process.stdin.on('data', function(chunk) {
    stdin += chunk;
});
 
 
process.stdin.on('end', function() {
    var array = stdin.split(' ');
    var arraySize = array.splice(0, 1);
    for (var i = 0; i < arraySize; i++) {
        array[i] = parseInt(array[i]);
    }

process.stdout.write(resolve(array, arraySize).toString());
});    


{{code}}",
            "process.stdin.resume();
var stdin = \"\";
process.stdin.on('data', function(chunk) {
    stdin += chunk;
});
 
 
process.stdin.on('end', function() {
    var array = stdin.split(' ');
    var arraySize = array.splice(0, 1);
    for (var i = 0; i < arraySize; i++) {
        array[i] = parseInt(array[i]);
    }

    process.stdout.write(\"[\"+resolve(array, arraySize).toString()+\"]\");
});

{{code}}",
            "process.stdin.resume();
var stdin = \"\";
process.stdin.on('data', function(chunk) {
    stdin += chunk;
});
 
 
process.stdin.on('end', function() {
    var array = stdin.split(' ');
    var arraySize = array.splice(0, 1);
    for (var i = 0; i < arraySize; i++) {
        array[i] = parseInt(array[i]);
    }

    process.stdout.write(\"[\"+resolve(array, arraySize).toString()+\"]\");
});

{{code}}"
        ];

        $javaWraps = [
            "import java.util.Scanner;
 
 
public class TrianglesAndRhombus {
 
   {{code}}
 
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        int triangleN = 0, rhombK = 0;
       
        triangleN = scanner.nextInt();
        rhombK = scanner.nextInt();
        System.out.print(resolve(triangleN, rhombK));
    }
}",
            "import java.lang.String;
import java.util.Scanner;
 
public class Brackets {
{{code}}
 
 
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        String stdin = scanner.nextLine();
        System.out.print(isBracketsPlacedCorrectly(stdin));
    }
}",
            "import java.util.Scanner;
import java.lang.Math;
 
public class Sorting {


    {{code}}

    public static void main(String[] args) {

        int arraySize = 0;

        Scanner scanner = new Scanner(System.in);
        arraySize = scanner.nextInt();

        int[] array = new int[arraySize];
        
        for (int i = 0; i < arraySize; i++) {
            array[i] = scanner.nextInt();
        }

        int[] result = resolve(array, arraySize);
        System.out.print(\"[\");
        for (int i = 0; i < arraySize; i++) {
            System.out.print(result[i]);
            if(i != arraySize-1)  System.out.print(\",\");

        }
        System.out.print(\"]\");
    }
}",
            "import java.util.Scanner;
public class test {
    
{{code}}

    public static void main(String[] args) {
        Scanner in = new Scanner(System.in);
        int a = in.nextInt();
        int b = in.nextInt();
        System.out.print(sum(a,b));
    }
}",
            "import java.lang.String;
import java.util.Scanner;
 
public class Numbers {
{{code}}
 
 
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        String number = scanner.nextLine().split(\" \")[1];
        System.out.print(resolve(number));
    }
}",
            "import java.lang.String;
import java.util.Scanner;
 
public class Sparrow {
{{code}}
 
 
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        String stdin = scanner.nextLine().split(\" \")[1];
        System.out.print(resolve(stdin));
    }
}",
            "import java.lang.String;
import java.util.Scanner;
 
public class Pangramms {
{{code}}
 
 
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        String stdin = scanner.nextLine().split(\" \")[1];
        System.out.print(isPangramm(stdin));
    }
}",
            "import java.lang.String;
import java.util.Scanner;
 
public class Mars {
{{code}}
 
 
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        String stdin = scanner.nextLine().split(\" \")[1];
        System.out.print(resolve(stdin));
    }
}",
            "import java.util.Scanner;
 
 
public class TrianglesAndRhombus {
 
   {{code}}
 
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        int triangleN = 0, pentagonN = 0;
       
        triangleN = scanner.nextInt();
        pentagonN = scanner.nextInt();
        System.out.print(resolve(triangleN, pentagonN));
    }
}",

            "import java.util.Scanner;
 
 
public class PeopleAndCats {
 
   {{code}}
 
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        int peopleN = 0, catsK = 0;
       
        peopleN = scanner.nextInt();
        catsK = scanner.nextInt();
        System.out.print(resolve(peopleN, catsK));
    }
}",
            "import java.util.Scanner;
 
 
public class Numbers {

    {{code}}
 
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        int first = 0, second = 0, third = 0;
       
        first = scanner.nextInt();
        second = scanner.nextInt();
        third = scanner.nextInt();
        System.out.print(resolve(first, second, third));
    }
}",
            "import java.util.Scanner;
 
 
public class Numbers {

    {{code}}
 
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        int first = 0, second = 0, third = 0;
       
        first = scanner.nextInt();
        second = scanner.nextInt();
        third = scanner.nextInt();
        System.out.print(resolve(first, second, third));
    }
}",
            "import java.util.Scanner;
 
 
public class Numbers {

    {{code}}
 
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        int first = 0, second = 0;
       
        first = scanner.nextInt();
        second = scanner.nextInt();
                System.out.print(resolve(first, second));
    }
}",
            "import java.util.Scanner;
 
 
public class Numbers {

    {{code}}
 
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        int first = 0, second = 0, third = 0;
       
        first = scanner.nextInt();
        second = scanner.nextInt();
        third = scanner.nextInt();
        System.out.print(resolve(first, second, third));
    }
}",
            "import java.util.Scanner;
 
 
public class Numbers {

    {{code}}
 
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        int first = 0, second = 0, third = 0;
       
        first = scanner.nextInt();
        second = scanner.nextInt();
        third = scanner.nextInt();
        System.out.print(resolve(first, second, third));
    }
}",
            "
import java.util.Scanner;
 
 
public class Numbers {

    {{code}}
 
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        int first = 0, second = 0;
       
        first = scanner.nextInt();
        second = scanner.nextInt();
                System.out.print(resolve(first, second));
    }
}",
            "
import java.util.Scanner;
 
 
public class Numbers {

    {{code}}
 
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        int first = 0;
       
        first = scanner.nextInt();
                       System.out.print(resolve(first));
    }
}",
            "
import java.util.Scanner;
 
 
public class Numbers {

    {{code}}
 
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        int first = 0, second = 0, third = 0;
       
        first = scanner.nextInt();
        second = scanner.nextInt();
        third = scanner.nextInt();
        System.out.print(resolve(first, second, third));
    }
}",
            "
import java.util.Scanner;
 
 
public class Numbers {

    {{code}}
 
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        int first = 0, second = 0;
       
        first = scanner.nextInt();
        second = scanner.nextInt();
                System.out.print(resolve(first, second));
    }
}",
            "
import java.util.Scanner;
import java.lang.Math;
 
public class Sorting {


    {{code}}

    public static void main(String[] args) {

        int arraySize = 0;

        Scanner scanner = new Scanner(System.in);
        arraySize = scanner.nextInt();

        int[] array = new int[arraySize];
        
        for (int i = 0; i < arraySize; i++) {
            array[i] = scanner.nextInt();
        }
System.out.print(resolve(array, arraySize));
    }
}",
            "
import java.util.Scanner;
import java.lang.Math;
 
public class Sorting {


    {{code}}

    public static void main(String[] args) {

        int arraySize = 0;

        Scanner scanner = new Scanner(System.in);
        arraySize = scanner.nextInt();

        int[] array = new int[arraySize];
        
        for (int i = 0; i < arraySize; i++) {
            array[i] = scanner.nextInt();
        }
System.out.print(resolve(array, arraySize));
    }
}",
            "
import java.util.Scanner;
import java.lang.Math;
 
public class Sorting {


    {{code}}

    public static void main(String[] args) {

        int arraySize = 0;

        Scanner scanner = new Scanner(System.in);
        arraySize = scanner.nextInt();

        int[] array = new int[arraySize];
        
        for (int i = 0; i < arraySize; i++) {
            array[i] = scanner.nextInt();
        }
System.out.print(resolve(array, arraySize));
    }
}",
            "
import java.util.Scanner;
import java.lang.Math;
 
public class Sorting {


    {{code}}

    public static void main(String[] args) {

        int arraySize = 0;

        Scanner scanner = new Scanner(System.in);
        arraySize = scanner.nextInt();

        int[] array = new int[arraySize];
        
        for (int i = 0; i < arraySize; i++) {
            array[i] = scanner.nextInt();
        }
System.out.print(resolve(array, arraySize));
    }
}",
            "
import java.util.Scanner;
import java.lang.Math;

public class Sorting {


    {{code}}

    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);

        int arraySize = scanner.nextInt();
        int array[] = new int[arraySize];
        for (int i = 0; i < arraySize; i++) {
            array[i] = scanner.nextInt();
        }
        int[] result = resolve(array, arraySize);
        System.out.print('[');
        for (int i = 0; i < arraySize; i++) {
            System.out.print(result[i]);
            if(i != arraySize-1)  System.out.print(\",\");
        }
        System.out.print(\"]\");

}
}",
            "
import java.util.Scanner;
import java.lang.Math;

public class Sorting {


    {{code}}

    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);

        int arraySize = scanner.nextInt();
        int array[] = new int[arraySize];
        for (int i = 0; i < arraySize; i++) {
            array[i] = scanner.nextInt();
        }
        int[] result = resolve(array, arraySize);
        System.out.print(\"[\");
        for (int i = 0; i < arraySize; i++) {
            System.out.print(result[i]);
            if(i != arraySize-1)  System.out.print(\",\");
        }
        System.out.print(\"]\");

    }
}"
        ];

        $cppWraps = [
            "#include <iostream>
 
using namespace std;
 
{{code}}
 
 
int main(int argc, char const *argv[])
{
    int triangleN = 0, rhombK = 0;
    cin >> triangleN;
    cin >> rhombK;
       
    cout << resolve(triangleN, rhombK);
    return 0;
}",
            "#include <iostream>
#include <string>
 
using namespace std;
 
{{code}}
 
int main() {
int arraySize = 0;
cin >> arraySize;
char *line = new char[arraySize];
cin >> line;    
        cout << isBracketsPlacedCorrectly(line);
    return 0;
}",
            "#include <iostream>
#include <cmath>

using namespace std;

{{code}}

int main(int argc, char const *argv[])
{

 int arraySize = 0,
 *array = 0,
 *result = 0;

 cin >> arraySize;
 array = new int[arraySize];
 
 for (int i = 0; i < arraySize; i++) {
 cin >> array[i];
 }

 result = resolve(array, arraySize);

 cout<<\"[\";
 for (int i = 0; i < arraySize; i++) {
 cout << result[i];
 if(i != arraySize-1) cout << \",\";
 }
 cout<<\"]\";

 return 0;
}",
            "#include <iostream>
using namespace std;

{{code}}

int main() {
    int a, b;
    cin >> a;
    cin >> b;
    cout <<sum(a,b)<< endl;
    return 0;
}",
            "#include <iostream>
#include <string>
 
using namespace std;
 
{{code}}
 
int main() {
int arraySize = 0;
cin >> arraySize;
char *line = new char[arraySize];
cin >> line;    
        cout << resolve(line);
    return 0;
}",
            "#include <iostream>
#include <string>
 
using namespace std;
 
{{code}}
 
int main() {
int arraySize = 0;
cin >> arraySize;
char *line = new char[arraySize];
cin >> line;            
cout << resolve(line);
    return 0;
}",
            "#include <iostream>
#include <string>
 
using namespace std;
 
{{code}}
 
int main() {
int arraySize = 0;
cin >> arraySize;
char *line = new char[arraySize];
cin >> line;         
cout << isPangramm(line);
    return 0;
}",
            "#include <iostream>
#include <string>
 
using namespace std;
 
{{code}}
 
int main() {
int arraySize = 0;
cin >> arraySize;
char *line = new char[arraySize];
cin >> line;        
cout << resolve(line);
    return 0;
}",
            "#include <iostream>
 
using namespace std;
 
{{code}}
 
 
int main(int argc, char const *argv[])
{
    int triangleN = 0, pentagonN = 0;
    cin >> triangleN;
    cin >> pentagonN;
       
    cout << resolve(triangleN, pentagonN);
    return 0;
}",
            "#include <iostream>
 
using namespace std;
 
{{code}}
 
 
int main(int argc, char const *argv[])
{
    int peopleN = 0, catsK = 0;
    cin >> peopleN;
    cin >> catsK;
       
    cout << resolve(peopleN, catsK);
    return 0;
}",
            "#include <iostream>
 
using namespace std;
 
{{code}}
 
 
int main(int argc, char const *argv[])
{
    int first = 0, second = 0, third = 0;
    cin >> first;
    cin >> second;
    cin >> third;
       
    cout << resolve(first, second, third);
    return 0;
}",
            "#include <iostream>
 
using namespace std;
 
{{code}}
 
 
int main(int argc, char const *argv[])
{
    int first = 0, second = 0, third = 0;
    cin >> first;
    cin >> second;
    cin >> third;
       
    cout << resolve(first, second, third);
    return 0;
}",
            "#include <iostream>
 
using namespace std;
 
{{code}}
 
 
int main(int argc, char const *argv[])
{
    int first = 0, second = 0;
    cin >> first;
    cin >> second;
           
    cout << resolve(first, second);
    return 0;
}",
            "#include <iostream>
 
using namespace std;
 
{{code}}
 
 
int main(int argc, char const *argv[])
{
    int first = 0, second = 0, third = 0;
    cin >> first;
    cin >> second;
    cin >> third;
       
    cout << resolve(first, second, third);
    return 0;
}",
            "#include <iostream>
 
using namespace std;
 
{{code}}
 
 
int main(int argc, char const *argv[])
{
    int first = 0, second = 0, third = 0;
    cin >> first;
    cin >> second;
    cin >> third;
       
    cout << resolve(first, second, third);
    return 0;
}",
            "#include <iostream>
 
using namespace std;
 
{{code}}
 
 
int main(int argc, char const *argv[])
{
    int first = 0, second = 0;
    cin >> first;
    cin >> second;
           
    cout << resolve(first, second);
    return 0;
}",
            "#include <iostream>
 
using namespace std;
 
{{code}}
 
 
int main(int argc, char const *argv[])
{
    int first = 0;
    cin >> first;
               
    cout << resolve(first);
    return 0;
}",
            "#include <iostream>
 
using namespace std;
 
{{code}}
 
 
int main(int argc, char const *argv[])
{
    int first = 0, second = 0, third = 0;
    cin >> first;
    cin >> second;
    cin >> third;
       
    cout << resolve(first, second, third);
    return 0;
}",
            "#include <iostream>
 
using namespace std;
 
{{code}}
 
 
int main(int argc, char const *argv[])
{
    int first = 0, second = 0;
    cin >> first;
    cin >> second;
           
    cout << resolve(first, second);
    return 0;
}",
            "#include <iostream>
#include <cmath>

using namespace std;

{{code}}

int main(int argc, char const *argv[])
{

 int arraySize = 0,
 *array = 0,
 result = 0;

 cin >> arraySize;
 array = new int[arraySize];
 
 for (int i = 0; i < arraySize; i++) {
 cin >> array[i];
 }

 result = resolve(array, arraySize);

 cout<< result;

 return 0;
}",
            "#include <iostream>
#include <cmath>

using namespace std;

{{code}}

int main(int argc, char const *argv[])
{

 int arraySize = 0,
 *array = 0,
 result = 0;

 cin >> arraySize;
 array = new int[arraySize];
 
 for (int i = 0; i < arraySize; i++) {
 cin >> array[i];
 }

 result = resolve(array, arraySize);

 cout<< result;

 return 0;
}",
            "#include <iostream>
#include <cmath>

using namespace std;

{{code}}

int main(int argc, char const *argv[])
{

 int arraySize = 0,
 *array = 0,
 result = 0;

 cin >> arraySize;
 array = new int[arraySize];
 
 for (int i = 0; i < arraySize; i++) {
 cin >> array[i];
 }

 result = resolve(array, arraySize);

 cout<< result;

 return 0;
}",
            "#include <iostream>
#include <cmath>

using namespace std;

{{code}}

int main(int argc, char const *argv[])
{

 int arraySize = 0,
 *array = 0,
 result = 0;

 cin >> arraySize;
 array = new int[arraySize];
 
 for (int i = 0; i < arraySize; i++) {
 cin >> array[i];
 }

 result = resolve(array, arraySize);

 cout<< result;

 return 0;
}",
            "#include <iostream>
#include <cmath>

using namespace std;

{{code}}

int main(int argc, char const *argv[])
{
  int arraySize = 0,
 *array = 0,
 *result = 0;

 cin >> arraySize;
 array = new int[arraySize];

 for (int i = 0; i < arraySize; i++) {
 cin >> array[i];
 }

 result = resolve(array, arraySize);

 cout<<\"[\";
 for (int i = 0; i < arraySize; i++) {
 cout << result[i];
 if(i != arraySize-1) cout << \",\";
 }
 cout<<\"]\";

 return 0;
}",
            "#include <iostream>
#include <cmath>

using namespace std;

{{code}}

int main(int argc, char const *argv[])
{
  int arraySize = 0,
 *array = 0,
 *result = 0;

 cin >> arraySize;
 array = new int[arraySize];

 for (int i = 0; i < arraySize; i++) {
 cin >> array[i];
 }

 result = resolve(array, arraySize);

 cout<<\"[\";
 for (int i = 0; i < arraySize; i++) {
 cout << result[i];
 if(i != arraySize-1) cout << \",\";
 }
 cout<<\"]\";

 return 0;
}"
        ];

        $testCases = [
            '5 7,11 8,100 100',
            '60 3*(2-5)+12*(4*(3*11-11/(33-7))+56)-12/12,81 3*(2-5)+12*(22-9)+11)*(4+(4*(3*11-11/(33-7))+56)-12/12,61 3*(2-5)+12*(4*(3*11-11/(33-7))+56)-12/12)',
            '3 0 0 0,5 3 5 0 1 7,7 0 6 4 2 10 22 4,9 2 3 3 57 89 543 25 0 8',
            '5 2,4 3,9 1,-1 2,2 0',
            '7 P204BT,7 X182YZ,7 a216bc,7 A216BC,7 ABC216',
            '30 <<<<>>--><--<<--<<>>>--><<<<<,20 <<<<>>>>-<<-<---->>,21 <<--<<<--<<<--<<<--<,20 >>--<--<-<--<<>>-->,15 >>-->->>->>-->',
            '47 Wepromptlyjudgedantiqueivorybucklesfortheprize,51 Wepromptlyjudgedantiqueivorybucklesforthenextprize,30 QuickzephyrsblowvexingdaftJim,34 Thequickbrownfoxjumpsoveralazydog,22 Squdgyfezjimpcrwthvox',
            '16 SDSSOSSOSSSSOOS,10 SOSCOSSSS,13 SDDSOLSWSOOO,4 SOS',
            '5 7,11 8,100 100',
            '5 7,11 8,100 100',
            '0 2 2,11 8 11,100 100 100,3 5 5,17 17 17',
            '0 2 8,8 8 11,100 100 100,3 5 5,17 17 17',
            '0 0,7 -8,-9 15,0 -5,17 18',
            '0 2 8,8 8 8,100 100 100,3 5 4,17 17 17',
            '35 6 17,15 20 0,100 100 0,3 5 2,17 17 17',
            '0 2,27 2,40 4,50 -5',
            '1000000,4400,1,37893',
            '40 20 7,0 6 3,10 -2 4,-2 7 3,27 10 8',
            '3 7,7 1,4 5,1 1',
            '9 1 13 4 0 5 0 77 9 0,3 0 2 0,8 7 0 70 17 0 8 10 10,1 1,2 0 0',
            '3 0 0 0,7 1 2 3 4 2 6 7,8 0 0 0 9 -3 7 0 1,3 0 2 0',
            '3 1 2 3,7 10 12 3 42 21 6 7,8 -2 3 4 9 -3 7 11 12,3 11 12 12',
            '3 0 4 0,7 1 1 1 1 1 1 7,8 0 0 0 0 9 0 0 0,3 0 2 2',
            '3 1 0 2,7 6 0 5 4 1 3 2,1 0,6 5 3 0 1 4 2',
            '3 1 2 3,7 -8 901 75 -4 -5 0 2,1 -100,4 150 -150 0 0'
        ];

        $answers = [
            "43\ 65\ 700",
            "100\ 2\ 1",
            "[0,0,0]\ [1,3,5,7,0]\ [0,2,4,4,6,10,22]\ [3,3,25,57,89,543,0,2,8]",
            "7\ 7\ 10\ 1\ 2",
            "100\ 3\ 3\ 100\ 3",
            "4\ 0\ 3\ 2\ 2",
            "1\ 100\ 100\ 100\ 5",
            "3\ 2\ 6\ 0",
            "50\ 73\ 800",
            "24\ 38\ 400",
            "0\ 8\ -1\ 3\ -1",
            "100\ 11\ -1\ 5\ -1",
            "100\ 7\ 15\ 0\ -1",
            "2\ -1\ -1\ 4\ -1",
            "11\ -5\ -100\ -2\ 0",
            "-2\ -1\ -8\ -10",
            "2000000\ 1126400\ 1048576\ 1212576",
            "-79\ -15\ 24\ -20\ -25",
            "3333333\ 7\ 44444\ 1",
            "4\ 1\ -1\ -1\ -1",
            "0\ 5\ 3\ 1",
            "0\ 2\ 0\ 0",
            "1\ 6\ 4\ 0",
            "[0,1,2]\ [6,1,4,5,0,2,3]\ [0]\ [4,2,1,0,5,3]",
            "[1,2,3]\ [0,100,75,0,0,0,2]\ [0]\ [100,0,0,0]"
        ];

        $jsStartFunctions = [
            "function resolve(triangleN, rhombK) {\n\n}",
            "function isBracketsPlacedCorrectly(formula){\n\n}",
            "function separateAndSort(array) {\n\n}",
            "function sum(a, b) {\r\n  c = a + b; \r\n  return c;\r\n}",
            "function resolve(line){\n\n}",
            "function resolve(line){\n\n}",
            "function resolve(line){\n\n}",
            "function resolve(line){\n\n}",
            "function resolve(triangleN, pentagonK) {\n\n}",
            "function resolve(peopleN, catsK) {\n\n}",
            "function resolve(first, second, third) {\n\n}",
            "function resolve(first, second, third) {\n\n}",
            "function resolve(first, second) {\n\n}",
            "function resolve(first, second, third) {\n\n}",
            "function resolve(first, second, third) {\n\n}",
            "function resolve(first, second) {\n\n}",
            "function resolve(number) {\n\n}",
            "function resolve(first, second, third) {\n\n}",
            "function resolve(first, second) {\n\n}",
            "function resolve(array, arraySize) {\n\n}",
            "function resolve(array, arraySize) {\n\n}",
            "function resolve(array, arraySize) {\n\n}",
            "function resolve(array, arraySize) {\n\n}",
            "function resolve(array, arraySize) {\n\n}",
            "function resolve(array, arraySize) {\n\n}",
        ];

        $javaStartFunctions = [
            "static int resolve(int triangleN, int rhombK) {\n\n}",
            "static int isBracketsPlacedCorrectly(String formula) {\n\n}",
            "public static int[] resolve(int[] array, int length) {\n\n}",
            "public static int sum(int a, int b) {\r\n  int c = a + b; \r\n  return c;\r\n}",
            "static int resolve(String line) {\n\n}",
            "static int resolve(String line) {\n\n}",
            "static int isPangramm(String phrase) {\n\n}",
            "static int resolve(String line) {\n\n}",
            "static int resolve(int triangleN, int pentagonK) {\n\n}",
            "static int resolve(int peopleN, int catsK) {\n\n}",
            "static int resolve(int first, int second, int third) {\n\n}",
            "static int resolve(int first, int second, int third) {\n\n}",
            "static int resolve(int first, int second) {\n\n}",
            "static int resolve(int first, int second, int third) {\n\n}",
            "static int resolve(int first, int second, int third) {\n\n}",
            "static int resolve(int first, int second) {\n\n}",
            "static int resolve(int number) {\n\n}",
            "static int resolve(int first, int second, int third) {\n\n}",
            "static int resolve(int first, int second) {\n\n}",
            "public static int resolve(int[] array, int arraySize) {\n\n}",
            "public static int resolve(int[] array, int arraySize) {\n\n}",
            "public static int resolve(int[] array, int arraySize) {\n\n}",
            "public static int resolve(int[] array, int arraySize) {\n\n}",
            "static int[] resolve(int []array, int arraySize)  {\n\n}",
            "static int[] resolve(int []array, int arraySize)  {\n\n}"
        ];

        $cppStartFunctions = [
            "int resolve(int triangleN, int rhombK) {\n\n}",
            "int isBracketsPlacedCorrectly(char formula[]){\n\n}",
            "int *resolve(int array[], int length) {\n\n}",
            "int sum(int a, int b) {\r\n  int c = a + b;  \r\n  return c;\r\n}",
            "int resolve(char line[]){\n\n}",
            "int resolve(char line[]){\n\n}",
            "int isPangramm(char phrase[]){\n\n}",
            "int resolve(char line[]){\n\n}",
            "int resolve(int triangleN, int pentagonK) {\n\n}",
            "int resolve(int peopleN, int catsK) {\n\n}",
            "int resolve(int first, int second, int third) {\n\n}",
            "int resolve(int first, int second, int third) {\n\n}",
            "int resolve(int first, int second) {\n\n}",
            "int resolve(int first, int second, int third) {\n\n}",
            "int resolve(int first, int second, int third) {\n\n}",
            "int resolve(int first, int second) {\n\n}",
            "int resolve(int number) {\n\n}",
            "int resolve(int first, int second, int third) {\n\n}",
            "int resolve(int first, int second) {\n\n}",
            "int resolve(int array[], int arraySize) {\n\n}",
            "int resolve(int array[], int arraySize) {\n\n}",
            "int resolve(int array[], int arraySize) {\n\n}",
            "int resolve(int array[], int arraySize) {\n\n}",
            "int * resolve ( int array[], int arraySize) {\n\n}",
            "int * resolve ( int array[], int arraySize) {\n\n}"
        ];

        DB::table('programming_tasks')->delete();

        foreach ($names as $key => $name) {
            DB::table('programming_tasks')->insert([
                "id" => $key + 1,
                "name" => $names[$key],
                "description" => json_encode($descriptions[$key], JSON_UNESCAPED_UNICODE),
                "number" => $taskNumbers[$key],
                "js_wrap" => $jsWraps[$key],
                "java_wrap" => $javaWraps[$key],
                "cpp_wrap" => $cppWraps[$key],
                "test_cases" => $testCases[$key],
                "answers" => $answers[$key],
                "js_start_function" => $jsStartFunctions[$key],
                "java_start_function" => $javaStartFunctions[$key],
                "cpp_start_function" => $cppStartFunctions[$key]
            ]);
        }
    }
}
