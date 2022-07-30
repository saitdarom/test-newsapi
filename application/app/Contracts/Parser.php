<?php


namespace App\Contracts;


use phpDocumentor\Reflection\Types\Boolean;

interface Parser
{
    /**
     * Перебирает значения по условиям запроса по всему массиву данных. Находит элемент, которого еще не было в БД. Отдает.
     * Метод нужен для прохода первый раз. Для сбора всех статей.
     *
     * Ответ должен быть в виде данного массива. В случае отсутствия новости - null.
     [
        "source"       => [
            'source_id'   => '',
            'name' => '',
        ],
        "author"       => '',
        "title"        => '',
        "description"  => '',
        "url"          => '',
        "url_to_image" => '',
        "published_at" => '',
        "content"      => '',
    ];
     * @param string $query
     * @return array|null
     */
    public function getNewsItemByQuery(string $query): ?array;


    /* @TODO Нужен еще один метод для запроса последних записей. От текущей даты до даты ближайшей публикации в БД.
     * Будем запускать только этот метод, после прохода метода выше первый раз.
     *
     *

     */



}
