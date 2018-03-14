#!/bin/bash

# Exit on failure
# set -e

REFERENCE_DUMP_FILE="assets/post-import.sql"
ASSETSDIR=assets
SCOPE=dev
ROOT=docroot
PROFILE=startup
UUID=410f6390-c5ff-483c-8ff7-99a373139af5

function run_command {
  TITLE=$1
  CMD=$2

  echo -e "\e[32m$TITLE\e[0m"
  echo -e "\e[33mExecuting: \e[0m$CMD"
  $CMD
}

function clean {
  if [ ! -e $ASSETSDIR ]; then
    mkdir $ASSETSDIR
  fi

  if [ -e $REFERENCE_DUMP_FILE ]; then
    rm $REFERENCE_DUMP_FILE
  fi
}

