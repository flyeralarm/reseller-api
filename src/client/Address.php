<?php
namespace flyeralarm\ResellerApi\client;


class Address
{
    /**
     * @var string
     */
    private $company = null;
    /**
     * @var string
     */
    private $gender = null;
    /**
     * @var string
     */
    private $firstName = null;
    /**
     * @var string
     */
    private $lastName = null;
    /**
     * @var string
     */
    private $address = null;
    /**
     * @var string
     */
    private $addressAdd = null;
    /**
     * @var string
     */
    private $postcode = null;
    /**
     * @var string
     */
    private $city = null;
    /**
     * @var string
     */
    private $county = null;
    /**
     * @var string
     */
    private $locale = null;
    /**
     * @var string
     */
    private $phone1 = null;

    /**
     * @param $company
     * @return $this
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @param $gender
     * @return $this
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @param $firstName
     * @return $this
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @param $lastName
     * @return $this
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @param $address
     * @return $this
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @param $addressAdd
     * @return $this
     */
    public function setAddressAdd($addressAdd)
    {
        $this->addressAdd = $addressAdd;

        return $this;
    }

    /**
     * @param $postcode
     * @return $this
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * @param $city
     * @return $this
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @param $county
     * @return $this
     */
    public function setCounty($county)
    {
        $this->county = $county;

        return $this;
    }

    /**
     * @param $locale
     * @return $this
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @param $phone1
     * @return $this
     */
    public function setPhone1($phone1)
    {
        $this->phone1 = $phone1;

        return $this;
    }

    /**
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getAddressAdd()
    {
        return $this->addressAdd;
    }

    /**
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getCounty()
    {
        return $this->county;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @return string
     */
    public function getPhone1()
    {
        return $this->phone1;
    }

    /**
     * @return array
     */
    public function getArray()
    {
        return array(
            'company' => $this->getCompany(),
            'gender' => $this->getGender(),
            'firstName' => $this->getFirstName(),
            'lastName' => $this->getLastName(),
            'address' => $this->getAddress(),
            'addressAdd' => $this->getAddressAdd(),
            'postcode' => $this->getPostcode(),
            'city' => $this->getCity(),
            'county' => $this->getCounty(),
            'locale' => $this->getLocale(),
            'phone1' => $this->getPhone1()
        );
    }

}