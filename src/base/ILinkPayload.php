<?php

namespace stitchua\tpay\base;

interface ILinkPayload
{
    /**
     * Entity which was paid for
     * Mandatory parameter!
     * @return string
     */
    public function getEntityId(): string;

    /**
     * Numeric identifier assigned to the merchant during the registration.
     * Mandatory parameter!
     * @return int
     */
    public function getId(): int;

    /**
     * Transaction amount with dot as decimal separator.
     * Mandatory parameter!
     * @return float
     */
    public function getAmount(): float;

    /**
     * Transaction description
     * Mandatory parameter!
     *
     * Any, up to 128 characters
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * Auxiliary parameter to identify the transaction on the merchant side.
     *
     * Any, up to 128 characters
     *
     * @return string
     */
    public function getCrc(): string;

    /**
     * Data for generating crc
     * @return array
     */
    public function getCrcData(): array;

    /**
     * The checksum used to verify the parameters received from the merchant.
     * When seller's verification code is not set, its value is assumed to be an empty string.
     * <br><b>Mandatory parameter!</b><br>
     *
     * Alphanumeric, 32 characters
     *
     * @return string
     */
    public function getMd5sum(): string;

    /**
     * Allow online payments only – disallows selection of channels, which at this time,
     * cannot process the payment in real time.
     *
     * 0 – no
     * 1 – yes
     *
     * @return int
     */
    public function getOnline(): int;

    /**
     * Bank group number selected by customer on seller's website.
     * @return int
     */
    public function getGroup(): ?int;

    /**
     * The URL address to which the transaction result will be sent via POST method.
     * Note: The Tpay system will use the URL provided in merchant panel or value of this parameter
     * if you enable the overriding in merchant panel (notifications tab).
     *
     * Alphanumeric, up to 512 characters
     *
     * @return string
     */
    public function getResultUrl(): string;

    /**
     * Tpay system will send notifications about transactions to this email.
     * If not present, Tpay system will use the default email set in the merchant panel.
     * You can pass multiple addresses by separating them with a comma.
     *
     * Alphanumeric, up to 512 characters
     *
     * @return string
     */
    public function getResultEmail(): string;

    /**
     * Description of the seller during the transaction.
     * By default, the value set in the merchant panel is used.
     *
     * Alphanumeric, up to 64 characters
     *
     * @return string
     */
    public function getMerchantDescription(): string;

    /**
     * Optional field used for card transactions made via Acquirer (Elavon / eService).
     * The value of the field is passed to Acquirer (Elavon / eService) as "TEXT REF. TRANSACTIONS ".
     *
     * Acceptable characters are a-z, A-Z (without Polish signs), 0-9, and space. All other characters will be cleared. Max 32 characters
     *
     * @return string
     */
    public function getCustomDescription(): string;

    /**
     * The URL to which the client will be redirected after the correct transaction processing.
     *
     * Alphanumeric, up to 512 characters
     *
     * @return string
     */
    public function getReturnUrl(): string;

    /**
     * The URL to which the client will be redirected in case transaction error occurs.
     * By default, the same as return_url.
     *
     * Alphanumeric, up to 512 characters
     *
     * @return string
     */
    public function getReturnErrorUrl(): string;



    /**
     * Customer language
     *
     * Only one of the: PL, EN
     * @return string
     */
    public function getLanguage(): string;

    /**
     * Customer email
     * Alphanumeric, up to 64 characters
     * @return string
     */
    public function getEmail(): string;

    /**
     * Customer name
     * Alphanumeric, up to 64 characters
     * @return string
     */
    public function getName(): string;

    /**
     * Customer address
     * Alphanumeric, up to 64 characters
     * @return string
     */
    public function getAddress(): string;

    /**
     * Customer city
     * Alphanumeric, up to 64 characters
     * @return string
     */
    public function getCity(): string;
    /**
     * Customer postal code
     * Alphanumeric, up to 10 characters
     * @return string
     */
    public function getZip(): string;

    /**
     * Customer country
     * Alphanumeric, 2 or 3 characters (ISO 3166-1)
     * @return string
     */
    public function getCountry(): string;

    /**
     * Customer telephone number
     * Alphanumeric, up to 16 characters
     * @return string
     */
    public function getPhone(): string;

    /**
     * Customer acceptance of tpay.com rules.
     * @return string
     */
    public function getAcceptTos(): string;

    /**
     * Maximum transaction payment date
     *
     * Date formatted as: YYYY:MM:DD:HH:MM (for Warsaw time GMT+1)
     *
     * @return string
     */
    public function getExpirationDate(): string;

    /**
     * Parameter protects expiration_date from unauthorized changes.
     * The parameter is mandatory if we limit the link in time.
     *
     * Alphanumeric, up to 32 characters
     *
     * @return string
     */
    public function getTimehash(): string;

}