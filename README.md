Semantic Search Project
=======================

This application is our answer to the task given by Slim Abdennadher in his 
lecture on the Semantic Web.

This project archive contains the initial [project proposal](proposal) and the 
final [documentation](documentation) as well as the data and application files.

## Getting started

In order to use this application, a local copy of some of the files is 
required (in particular, the search interface and the Fuseki database). The 
easiest way to download these is to use the 
[complete archive](https://github.com/seaneble/dhbw_semanticweb/archive/master.zip) 
and ignore some of the other content. Unzip the archive after downloading it.

## Starting the server

This application uses Apache Jena Fuseki to interact with its data. It is 
therefore required to install this software before trying to use the 
application. Fuseki can be aquired from the 
[project website](http://jena.apache.org/download/index.cgi).

After properly unpacking Fuseki, the server can be started with the following 
command:

    $> ./fuseki-server --update --loc=PATH_OF_GITHUB_CLONE/database /ds


