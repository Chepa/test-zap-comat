## Приветствую вас!
Цель тестового задания - выявить ваши навыки по:

- Интерпретации заданий от заказчика
- Использованию инструментария в проектировании решений комплексных задач
- Базовому владению Laravel и подходу к написанию кода

Кроме того - задание спроектировано так, чтобы оно относительно легко воспринималось человеком, но плохо поддавалось интерпретации с помощью LLM.
Умение использовать ChatGPT в решении задач - похвальный навык, однако AI в данный момент это дополнение к разработчику, а не его замена.

Пожалуйста, не делайте публичных форков данного Git!
Это помешает другим участникам честно выполнить задание.

## Описание тестового сайта
Тестовый сайт представляет из себя каталог с 10.000 товаров.
Каждый товар имеет id, название и частотность

## Задание - добавить блок рекомендуемых товаров
Блок рекомендуемых товаров преследует несколько целей - во первых показать потребителю товары, которые могут его заинтересовать.
Во вторых - повысить ссылочный вес страниц на которые он ссылается.

Поэтому, для генерации качественного блока рекомендуемых товаров следует использовать 2 основные метрики -
1) Близость рекомендуемого товара к текущему
2) Популярность рекомендумого товара

На тестовом сайте нет групп, поэтому "близость" рекомендуется определять как близость по названию товаров - чем больше совпадений в названии рекомендуемого товара, тем ближе он считается к текущему товару.
Популярность - в нашем случае у каждого товара есть "частотность" - как часто товар запрашивают в поисковых системах.

Итоговый скоринг предлагается определять как произведение близости на популярность.

Необходимо отобрать по 20 рекомендаций для каждого товара

## Дополнительные задания
Дополнительные задания не обязательны к выполнению, но их выполнение показывает более высокий уровень навыков.
1) Рекомендации должны выбираться случайным образом на основе скоринга. Т.е. близость по названию и популярность повышает шансы, но не гарантирует попадание в выборку
2) Рекомендации не должны выбираться во время построения страницы, а должны быть определены заранее
3) Рекомендации могут работать с 1.000.000 товаров, а не 10.000 без значительных задержек во времени загрузки страницы (оценивается "тяжесть" запросов к БД - насколько быстро они выполняются, а не время загрузки страницы в браузере)
4) Рекомендации автоматически добавляются для новых созданных товаров
5) На странице товара написано, сколько на него ссылаются через рекомендуемые товары

## О докер-контейнере
Задание упаковано в докер-контейнер так, чтобы его можно было легко развернуть и модернезировать.
Достаточно прописать команду docker-compose up -d и тестовый сайт развернется на http://localhost:6969
БД будет доступна по localhost:6970, логин - root, пароль - ZcW1knBAIlX, БД - laravel

Докер контейнер настроен так, чтобы стримить содержимое папки проекта напрямую в докер-образ.
Это неправильное решение для продакшена, однако в локальной среде для разработки повышает удобство, т.к. вам не придется перестраивать образ или обновлять volume для внесения изменений на сайте - они будут происходить автоматически.

Однако такое решение, кроме проблем с безопасность и изолированностью, создает и проблемы с производительностью - сайт довольно долго грузится.
Предлагается игнорировать данную проблему в текущем тестовом задании.

## Как сдать задание
Предлагается 2 варианта
1) Прислать архив с кодом (без папки vendor) на почту liconn@mail.ru
2) Сделать ПРИВАТНЫЙ форк (закрыть его от публичного доступа) и расшарить его на ikonnikoff. Не забудьте прислать уведомление о том, как выполните задание.

Удачи вам! Да прибудет с вами сила.
