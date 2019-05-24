<?php


use Illuminate\Database\Seeder;

class TasksSeederTest extends Seeder
{
    public function run()
    {
        $names = [
            "Ромбы и треугольники",
            "Правильно ли расставлены скобки?",
            "Разделяй и сортируй!",
            "Solve Me First",
            "Номера автомобилей",
            "Стрелы",
            "Панграмма",
            "Изучение Марса",
            "Ромбы и пятиугольники",
            "Люди и коты",
            "Третий лишний",
            "Определение",
            "Арифметика",
            "Золотая середина",
            "Вычитание",
            "По ту сторону нуля",
            "Мега-рост",
            "Мега-спад",
            "Копирование",
            "Среди нулей",
            "Я - больше",
            "Ближе всех",
            "Не такой, как все",
            "Четное-нечетное",
            "Границы",
        ];

        $descriptions = [
            [
                'problem' => 'Посчитать количество верхушек в N треугольников и К ромбов.',
                'note' => 'N и K передаются параметрами функции и 0 < N, K < 10000. Функция возвращает суммарное количество углов.',
                'example' => [
                    'input' => '1, 1',
                    'output' => '7'
                ]
            ],
            [
                'problem' => 'Определить правильность расстановки круглых скобок в математическом выражении.',
                'note' => 'Параметром функции передается строка с математическим выражением. Функция должна вернуть 100, если скобки расставлены правильно, в противном случае - количество лишних скобок.',
                'example' => [
                    'input' => '(2  * (3 + 5)) / 12 + 14)',
                    'output' => '1'
                ]
            ],
            [
                'problem' => 'Дан массив целых чисел, который передается параметром функции. Нужно разместить элементы в массиве таким образом: сначала массива должны быть нечетные числа, отсортированные по росту, после них - парные, также отсортированы по росту.',
                'note' => 'Функция параметром принимает исходный массив и возвращает отсортированный полученный массив.',
                'example' => [
                    'input' => '[1, 8, 3, 4, 5, 2, 7, 6, 9]',
                    'output' => '[1, 3, 5, 7, 9, 2, 4, 6, 8]'
                ]
            ],
            [
                'problem' => 'Это первое задание, цель которого познакомить вас с порталом и отправкой задач. Вам нужно посчитать сумму 2 чисел. В функцию (метод) передается 2 значения a и b, функция возвращает сумму этих значений (-1000 <a, b <1000)',
                'note' => 'В этой задаче мы предоставляем вам рабочий код, его не обязательно менять. Да, мы уже написали все за вас, отправляйте :). В этом и следующих задачах вам не нужно писать всю программу, только функцию/метод, которая принимает на вход заданные параметры, обрабатывает их и возвращает (return) необходимые значения, все остальное уже написано нами. Библиотеки, необходимые для выполнения задания также уже подключены. Программа должна быть длиной менее 4500 символов.',
                'example' => [
                    'input' => '',
                    'output' => ''
                ]
            ],
            [
                'problem' => 'Основная часть государственного регистрационного номера состоит из 6 символов: трех букв и трех цифр. Сначала идет буква, затем 3 цифры и еще 2 буквы заканчивают запись. Как цифр могут использоваться любые цифры от 0 до 9, а в качестве букв только заглавные буквы, обозначение которых присутствуют как в английском, так и в российской алфавите, то есть только следующие символы: A, B, C, E, H, K , M, O, P, T, X, Y. Например, «P204BT» - правильный номер, а «X182YZ» и «ABC216» - нет. Ваша задача - определить, какие из номеров соответствуют принятому стандарту, а какие нет.',
                'note' => 'Функция принимает строку - автомобильный номер. Функция возвращает 100, если номер правильный, или количество букв в номере, если не соответствует стандарту.',
                'example' => [
                    'input' => 'P204BT',
                    'output' => '100'
                ]
            ],
            [
                'problem' => 'Задана последовательность, состоящая только из символов ">", "<" и "-". Нужно найти количество стрел, которые спрятаны в этой последовательности. Стрелы - это подстроки вида ">>-->" и "<--<<".',
                'note' => 'Функции параметром дается строка, состоящая из символов ">", "<" и "-" (без пробелов). Строка состоит не более чем из 250 символов. Функция возвращает количество найденных стрел.',
                'example' => [
                    'input' => '<<<<>>--><--<<',
                    'output' => '2'
                ]
            ],
            [
                'problem' => 'Вам дана строка, состоящая из латинских букв. Строка называется панграмма, если она содержит каждую из 26 латинских букв хотя бы раз. Определите является ли строка панграммой.',
                'note' => 'Функция принимает параметром одну строку. Функция должна вернуть 100, если строка является панграммой, в противном случае - количество отсутствующих букв (чтобы строка считалась панграммой).',
                'example' => [
                    'input' => 'Wepromptlyjudgedantiqueivorybucklesforthenextprize',
                    'output' => '100'
                ]
            ],
            [
                'problem' => 'Корабль Волли потерпел крушение на Марсе и шлет сигнал SOS на землю. Космическая радиация изменила некоторые буквы в послании.',
                'note' => 'Функции параметром дается строка. Так как исходное сообщение состоит из повторения фразы SOS, то длина строки кратна 3. Функция должна вернуть количество букв, измененных радиацией.',
                'example' => [
                    'input' => 'SOSSPSSQSSOR',
                    'output' => '3'
                ]
            ],
            [
                'problem' => 'Посчитать количество вершин у N треугольников и К пятиугольников.',
                'note' => 'N и K передаются параметрами функции и 0 < N, K < 10000. Функция возвращает суммарное количество углов.',
                'example' => [
                    'input' => '1, 1',
                    'output' => '8'
                ]
            ],
            [
                'problem' => 'Посчитать количество глаз у N людей и К котов.',
                'note' => 'N и K передаются параметрами функции и 0 < N, K < 10000. Функция возвращает суммарное количество глаз.',
                'example' => [
                    'input' => '1, 1',
                    'output' => '4'
                ]
            ],
            [
                'problem' => 'На вход в функцию дается три целых числа, притом два из них одинаковы. Надо вернуть то, которое отличается от остальных или же вернуть -1 если все три равны между собой.',
                'note' => '',
                'example' => [
                    'input' => '1, 1, 3',
                    'output' => '3'
                ]
            ],
            [
                'problem' => 'На вход в функцию дается три целых числа. Надо вернуть 100, если они все отличаются друг от друга, самое большое среди них, если какие-то из них равны, и -1, если они все равны друг другу.',
                'note' => '',
                'example' => [
                    'input' => '1, 2, 3',
                    'output' => '100'
                ]
            ],
            [
                'problem' => 'На вход в функцию приходит два целых числа. Надо вернуть 100, если сумма этих чисел равна их произведению. Надо вернуть самое большое среди этих чисел, если либо сумма либо произведение этих чисел меньше нуля. В остальных случаях вернуть -1.',
                'note' => '',
                'example' => [
                    'input' => '5, -3',
                    'output' => '5'
                ]
            ],
            [
                'problem' => 'На вход в функцию дается три целых числа. Нужно вернуть число, значение которого находится между двумя другими. Если же они все равны между собой, то надо вернуть -1.',
                'note' => '',
                'example' => [
                    'input' => '7, 4, 5',
                    'output' => '5'
                ]
            ],
            [
                'problem' => 'На вход в функцию приходит три числа. Надо отнимать от первого числа второе  до тех пор, пока полученый результат не станет меньше третьего числа, и после этого нужно вернуть результирующее значение.',
                'note' => '',
                'example' => [
                    'input' => '20, 3, 10',
                    'output' => '8'
                ]
            ],
            [
                'problem' => 'На вход в функцию приходит два целых числа. Надо к первому числу добавить второе, затем отнять второе число умноженное на само себя. Это надо повторить до тех пор (начиная с прибавления к полученному результату второго числа), пока в результате не получим число < 0, и этот результат уже надо будет вернуть.',
                'note' => 'Гарантируется, что рано или поздно значение станет меньше 0.',
                'example' => [
                    'input' => '20, 4',
                    'output' => '-4'
                ]
            ],
            [
                'problem' => 'На вход в функцию приходит одно число. Надо это число увеличивать в два раза до тех пор, пока оно не станет больше 1 000 000. Полученное число вернуть из функции.',
                'note' => 'Гарантируется, что рано или поздно значение превысит 1 000 000.',
                'example' => [
                    'input' => '500 001',
                    'output' => '1 000 002'
                ]
            ],
            [
                'problem' => 'На вход в функцию дается три параметра - целых числа. Надо от первого числа отнять второе, после этого отнять второе-1, потом второе-2... и так количество раз, равное значению третьего числа. Результат вернуть из функции.',
                'note' => 'Первое и второе число могут быть отрицательными.',
                'example' => [
                    'input' => '20 5 3',
                    'output' => '8'
                ]
            ],
            [
                'problem' => 'На вход в функцию приходит два числа, притом первое - от 1 до 9. Надо вернуть число, состоящее из одинаковых цифр, равных первому параметру, при этом количество этих цифр должно быть равно второму параметру.',
                'note' => '',
                'example' => [
                    'input' => '2, 4',
                    'output' => '2222'
                ]
            ],
            [
                'problem' => 'На вход в функцию приходит массив целых чисел, а вторым параметром - его размер. Найдите в массиве первое число, которое окружено нулями. Если такое число не найдено - верните -1, иначе верните индекс такого элемента.',
                'note' => '',
                'example' => [
                    'input' => '[0, 4, 0, 8], 4',
                    'output' => '1'
                ]
            ],
            [
                'problem' => 'На вход в функцию приходит массив целых чисел, а вторым параметром - его размер. Найдите в массиве количество элементов, которые больше чем предыдущий элемент и верните это число из функции.',
                'note' => '',
                'example' => [
                    'input' => '[5, 2, 8, 9], 4',
                    'output' => '2'
                ]
            ],
            [
                'problem' => 'На вход в функцию приходит массив целых чисел, а вторым параметром - его размер. Найдите в массиве элемент который наиболее близок к 0, и верните индекс этого элемента.',
                'note' => '',
                'example' => [
                    'input' => '[5, 2, 8, 9], 4',
                    'output' => '1'
                ]
            ],
            [
                'problem' => 'На вход в функцию приходит массив целых чисел, а вторым параметром - его размер. Найдите в массиве единственный элемент, который отличается от всех остальных, и верните индекс этого элемента.',
                'note' => '',
                'example' => [
                    'input' => '[5, 5, 8, 5], 4',
                    'output' => '2'
                ]
            ],
            [
                'problem' => 'На вход в функцию приходит массив целых чисел, а вторым параметром - его размер. Поменяйте в массиве местами четные и следующие за ними (при счете) нечетные элементы 0 и 1, 2 и 3, 4 и 5, и т.д. Если массив имеет нечетное количество элементов, то последний элемент не трогайте. Нужно вернуть отсортированный полученный массив.',
                'note' => '',
                'example' => [
                    'input' => '[1, 4, 3, 2, 0], 5',
                    'output' => '[0, 4, 2, 3, 1]'
                ]
            ],
            [
                'problem' => 'На вход в функцию приходит массив целых чисел, а вторым параметром - его размер. Измените массив следующим образом: каждый элемент, который меньше 0, замените на 0, а каждый элемент, который больше 100 - замените на 100. Верните измененный полученный массив.',
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
    process.stdout.write(resolve(stdin).toString());
});
 
{{code}}",
            "process.stdin.resume();
var stdin = \"\";
process.stdin.on('data', function(chunk) {
    stdin += chunk;
});
process.stdin.on('end', function() {
    process.stdout.write(resolve(stdin).toString());
});
 
{{code}}",
            "process.stdin.resume();
var stdin = \"\";
process.stdin.on('data', function(chunk) {
    stdin += chunk;
});
process.stdin.on('end', function() {
    process.stdout.write(resolve(stdin).toString());
});
 
{{code}}",
            "process.stdin.resume();
var stdin = \"\";
process.stdin.on('data', function(chunk) {
    stdin += chunk;
});
process.stdin.on('end', function() {
    process.stdout.write(resolve(stdin).toString());
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
    var third = parseInt(array[1]);
 
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
    var third = parseInt(array[1]);
 
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
    var third = parseInt(array[1]);
 
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
    var third = parseInt(array[1]);
 
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
    var third = parseInt(array[1]);
 
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
        String number = scanner.nextLine();
        System.out.print(resolve(number));
    }
}",
            "import java.lang.String;
import java.util.Scanner;
 
public class Sparrow {
{{code}}
 
 
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        String stdin = scanner.nextLine();
        System.out.print(resolve(stdin));
    }
}",
            "import java.lang.String;
import java.util.Scanner;
 
public class Pangramms {
{{code}}
 
 
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        String stdin = scanner.nextLine();
        System.out.print(isPangramm(stdin));
    }
}",
            "import java.lang.String;
import java.util.Scanner;
 
public class Mars {
{{code}}
 
 
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        String stdin = scanner.nextLine();
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
        for (int i = 0; i < 3; i++) {
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
        for (int i = 0; i < 3; i++) {
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

        $keys = [3,0,10,14,19,1];

        foreach ($keys as $key) {
            \Illuminate\Support\Facades\DB::table('programming_tasks')->insert([
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