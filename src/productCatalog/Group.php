<?php
namespace flyeralarm\ResellerApi\productCatalog;

class Group
{
    /**
     * @var int
     */
    private $productgroup_id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $image;

    /**
     * @var string
     */
    private $language;


    /**
     * @param $productgroup_id
     * @param $name
     * @param $description
     * @param $image_uri
     * @param $language
     */
    public function __construct($productgroup_id, $name, $description, $image_uri, $language)
    {

        $this->productgroup_id = $productgroup_id;
        $this->name = $name;
        $this->description = $description;
        $this->image = $image_uri;
        $this->language = $language;
    }

    /**
     * @return int
     */
    public function getProductGroupId()
    {
        return $this->productgroup_id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getImageURL()
    {
        return $this->image;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }
}
