<?php

namespace Arkade\Apparel21\Entities;

class ProductNote
{
    /**
     * Code.
     *
     * @var string
     */
    protected $code;

    /**
     * Name.
     *
     * @var string
     */
    protected $name;

    /**
     * Note.
     *
     * @var string
     */
    protected $note;

    /**
     * Return code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set code.
     *
     * @param  string $code
     * @return static
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name.
     *
     * @param  string $name
     * @return static
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get note.
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set note.
     *
     * @param  string $note
     * @return static
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }
}