<?php


namespace App\Services\Parsers;



interface Parser
{
    /**
     * Перебирает значения по условиям запроса по всему массиву данных. Находит элементы, которого еще не было в БД. Отдает.
     * Для сбора всех статей.

     * @param string $query
     * @return array
     */
    public function getNewItemsByQuery(string $query): array;


    /**
     * Перебирает значения по условиям запроса по всему массиву данных. Находит элементы, которого еще не было в БД. Отдает.
     * Забирает за последний час

     * @param string $query
     * @return array
     */
    public function getLastNewItemsByQuery(string $query): array;




}
