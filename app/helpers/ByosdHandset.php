<?php

namespace NomadicBits\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ByosdHandset
 */
class ByosdHandset
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $manufacturer;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $model;

    /**
     * @var string
     */
    private $dataType;

    /**
     * @var boolean
     */
    private $isLte;

    /**
     * @var boolean
     */
    private $isTriband;

    /**
     * @var boolean
     */
    private $isDataOnly;

    /**
     * @var boolean
     */
    private $created_at;

    /**
     * @var boolean
     */
    private $updated_at;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set manufacturer
     *
     * @param string $manufacturer
     * @return ByosdHandset
     */
    public function setManufacturer($manufacturer)
    {
        $this->manufacturer = $manufacturer;
    
        return $this;
    }

    /**
     * Get manufacturer
     *
     * @return string 
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ByosdHandset
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set model
     *
     * @param string $model
     * @return ByosdHandset
     */
    public function setModel($model)
    {
        $this->model = $model;
    
        return $this;
    }

    /**
     * Get model
     *
     * @return string 
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set dataType
     *
     * @param string $dataType
     * @return ByosdHandset
     */
    public function setDataType($dataType)
    {
        $this->dataType = $dataType;
    
        return $this;
    }

    /**
     * Get dataType
     *
     * @return string 
     */
    public function getDataType()
    {
        return $this->dataType;
    }

    /**
     * Set isLte
     *
     * @param boolean $isLte
     * @return ByosdHandset
     */
    public function setIsLte($isLte)
    {
        $this->isLte = $isLte;
    
        return $this;
    }

    /**
     * Get isLte
     *
     * @return boolean 
     */
    public function getIsLte()
    {
        return $this->isLte;
    }

    /**
     * Set isTriband
     *
     * @param boolean $isTriband
     * @return ByosdHandset
     */
    public function setIsTriband($isTriband)
    {
        $this->isTriband = $isTriband;
    
        return $this;
    }

    /**
     * Get isTriband
     *
     * @return boolean 
     */
    public function getIsTriband()
    {
        return $this->isTriband;
    }

    /**
     * Set isDataOnly
     *
     * @param boolean $isDataOnly
     * @return ByosdHandset
     */
    public function setIsDataOnly($isDataOnly)
    {
        $this->isDataOnly = $isDataOnly;
    
        return $this;
    }

    /**
     * Get isDataOnly
     *
     * @return boolean 
     */
    public function getIsDataOnly()
    {
        return $this->isDataOnly;
    }
}
