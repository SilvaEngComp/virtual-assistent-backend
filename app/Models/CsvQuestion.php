<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class CsvQuestion
{

    private string $description;
    private string $answare;
    private array $path;

    function __construct(array $csvData)
    {
        if (count($csvData) >= 3) {
            $this->setDescription($csvData[0]);
            $this->setAnsware($csvData[1]);
            $this->setPath($csvData[2]);
        } else {
            $this->setDescription('');
            $this->setAnsware('');
            $this->setPath('');
        }
    }

    public function build()
    {
        return [
            "description" => $this->getDescription(),
            "answare" => $this->getAnsware(),
            "path" => $this->getPath(),
        ];
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of answare
     */
    public function getAnsware()
    {
        return $this->answare;
    }

    /**
     * Set the value of answare
     *
     * @return  self
     */
    public function setAnsware($answare)
    {
        $this->answare = $answare;

        return $this;
    }

    /**
     * Get the value of path
     */
    public function getPath(): array
    {
        return $this->path;
    }

    /**
     * Set the value of path
     *
     * @return  self
     */
    public function setPath($path)
    {

        $this->path = explode('/', $path);

        return $this;
    }
}
