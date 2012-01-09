#!/bin/bash
echo "compile source"
nanoc compile
echo "copy local files to mathiaskarstaedt.de"
scp -r output/* web83@mathiaskarstaedt.de:~/html/mathiaskarstaedt
echo "deploy done."

