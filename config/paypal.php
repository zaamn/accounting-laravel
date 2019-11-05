<?php

return array(
    /** set your paypal credential **/
    'client_id' =>'AS2GGJ0I0QRbGewH0-xdrOPI17jxxlJfIeo67Etd0mpX3dGnZD6ZPn9YlogWoaH2r4G0zA1hQm34CH_3',
    'secret' => 'EEuJ5tgg9O4Y2alCmQi9xOL9IzTWcPExjMN7i3eJVLeUBobq_Fc5yYUxEGBX5Qgrq7H5HwXIkwqwgVyQ',
    /**
     * SDK configuration
     */
    'settings' => array(
        /**
         * Available option 'sandbox' or 'live'
         */
        'mode' => 'sandbox',
        /**
         * Specify the max request time in seconds
         */
        'http.ConnectionTimeOut' => 1000,
        /**
         * Whether want to log to a file
         */
        'log.LogEnabled' => true,
        /**
         * Specify the file that want to write on
         */
        'log.FileName' => storage_path() . '/logs/paypal.log',
        /**
         * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
         *
         * Logging is most verbose in the 'FINE' level and decreases as you
         * proceed towards ERROR
         */
        'log.LogLevel' => 'FINE'
    ),
);