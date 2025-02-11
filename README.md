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

After properly unpacking Fuseki, move or copy the ```lib``` folder from Jena 
into the Fuseki root folder.
Fuseki needs a configuration file, which is given as a 
[template](fusekiconf.ttl) within the project directory. Please copy this to the
Fuseki root directory (relative paths do not seem to work) and change line 43 to
contain the absolute path to the [database](database) directory of the project.

Finally, start the server with the following command:

    $> java -cp lib/jena-sdb-1.5.1.jar:lib/jena-arq-2.12.1.jar:fuseki-server.jar org.apache.jena.fuseki.FusekiCmd --config fusekiconf.ttl

Beware of blanks or tilde characters in the path to the database as Java does 
not seem to support them.

