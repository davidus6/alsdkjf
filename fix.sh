#!/usr/bin/env bash

iconv -f utf-8 -t ISO-8859-2 index.php>temp.php
rm index.php
mv temp.php index.php

iconv -f utf-8 -t ISO-8859-2 udalosti.php>temp.php
rm udalosti.php
mv temp.php udalosti.php

iconv -f utf-8 -t ISO-8859-2 interpreti.php>temp.php
rm interpreti.php
mv temp.php interpreti.php

iconv -f utf-8 -t ISO-8859-2 registration.php>temp.php
rm registration.php
mv temp.php registration.php