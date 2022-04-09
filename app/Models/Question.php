<?php

namespace App\Models;

class Question
{
    private string $description;
    private string $answare;

    /**
     * Get the value of answare
     *
     * @return  string
     */
    public function getAnsware()
    {
        return $this->answare;
    }

    /**
     * Set the value of answare
     *
     * @param  string  $answare
     *
     * @return  self
     */
    public function setAnsware(string $answare)
    {
        $this->answare = $answare;

        return $this;
    }

    /**
     * Get the value of description
     *
     * @return  string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @param  string  $description
     *
     * @return  self
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }
}
