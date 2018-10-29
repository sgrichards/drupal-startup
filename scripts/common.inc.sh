#!/bin/bash

# Exit on failure
set -e

function run_command {
  TITLE=$1
  CMD=$2

  echo -e "\e[32m$TITLE\e[0m"
  echo -e "\e[33mExecuting: \e[0m$CMD"
  $CMD
}
