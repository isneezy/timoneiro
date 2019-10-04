<?php

namespace Isneezy\Timoneiro\FormFields;

interface HandlerInterface
{
    /**
     * @param DataTypeField $field
     * @param DataType      $dataType
     * @param Model         $data
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function handle($field, $dataType, $data);

    /**
     * @param DataTypeField $field
     * @param DataType      $dataType
     * @param Model         $data
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createContent($field, $dataType, $data);

    /**
     * @param string $driver
     *
     * @return bool
     */
    public function supports($driver);

    /**
     * @return string
     */
    public function getCodename();

    /**
     * @return string
     */
    public function getName();
}
