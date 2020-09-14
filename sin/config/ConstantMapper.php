<?php
/**
 * Created by PhpStorm.
 * User: sin
 * Date: 9/9/2020
 * Time: 3:57 μμ
 */

namespace SinHelper\Config;

abstract class ConstantMapper
{
    // Database Stuff @todo: Replace with the actual OC config

    const DB_HOSTNAME = 'localhost';
    const DB_USERNAME = 'nwkqgegjee';
    const DB_PASSWORD = 'Vv5EJSJq9k';
    const DB_DATABASE = 'nwkqgegjee';
    const DB_PREFIX = 'oc_';

    // Website Stuff

    const WEBSITE_BASE_URL = 'https://phpstack-165911-1473051.cloudwaysapps.com/';


    // API Credentials Stuff

    const API_BASE_URL = 'https://401006892011.oncloud.gr/s1services';
    const API_COMPANY_ID = 1;
    const API_FIRST_SCALAR_YEAR = 2020;
    const API_BRANCH = 1;
    const API_USERNAME = 'admin';
    const API_PASSWORD = '';

    // API Constants Stuff - Dont change theese one

    const API_SERVICE_SET_DATA = 'setdata';
    const API_SERVICE_GET_DATA = 'getdata';
    const API_ACTION_INFO = 'info';
    const API_ACTION_READ = 'read';
    const API_ACTION_WRITE = 'write';
    const API_MODE_INSERT = 'insert';
    const API_MODE_UPDATE = 'update';

    // Lib Config

    const NOTIFY_ADMIN_ON_ERROR = false;
    const ERROR_NOTIFIER_EMAIL = 'kontokostas.thanasis@gmail.com';



    // Messages

    const DEFAULT_UNKNOWN_ERROR_MESSAGE = 'Something went wrong. Check the log files for more info!';
}