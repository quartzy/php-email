#!/usr/bin/env bash

bash <(curl -s https://codecov.io/bash) || echo 'Codecov failed to upload'
