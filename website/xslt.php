<?php

header('Content-type: text/xsl');

if ($urlParam = isset($_GET['query'])) {
    $query = $_GET['query'];
}
echo '<?xml version="1.0"?>';

?>

<!--

XSLT script to format SPARQL Query Results XML Format into xhtml

Copyright Â© 2004, 2005 World Wide Web Consortium, (Massachusetts
Institute of Technology, European Research Consortium for
Informatics and Mathematics, Keio University). All Rights
Reserved. This work is distributed under the W3CÂ® Software
License [1] in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or
FITNESS FOR A PARTICULAR PURPOSE.

[1] http://www.w3.org/Consortium/Legal/2002/copyright-software-20021231

Version 1 : Dave Beckett (DAWG)
Version 2 : Jeen Broekstra (DAWG)
Customization for SPARQler: Andy Seaborne
URIs as hrefs in results : Bob DuCharme & Andy Seaborne

> -    <xsl:for-each select="//res:head/res:variable">
> +    <xsl:for-each select="/res:sparql/res:head/res:variable">

-->

<xsl:stylesheet version="2.0"
		xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
		xmlns="http://www.w3.org/1999/xhtml"
		xmlns:res="http://www.w3.org/2005/sparql-results#"
		xmlns:fn="http://www.w3.org/2005/xpath-functions"
		exclude-result-prefixes="res xsl">

  <!--
    <xsl:output
    method="html"
    media-type="text/html"
    doctype-public="-//W3C//DTD HTML 4.01 Transitional//EN"
    indent="yes"
    encoding="UTF-8"/>
  -->

  <!-- or this? -->

  <xsl:output
   method="xml" 
   indent="yes"
   encoding="UTF-8" 
   doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN"
   doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"
   omit-xml-declaration="no" />

    <xsl:template match="res:link">
      <p>Link to <xsl:value-of select="@href"/></p>
    </xsl:template>

    <xsl:template name="header">
      <div>
        <h2>Header</h2>
        <xsl:apply-templates select="res:head/res:link"/>
      </div>
    </xsl:template>

  <xsl:template name="boolean-result">
    <div>
      <p>ASK => <xsl:value-of select="res:boolean"/></p>
    </div>
  </xsl:template>


  <xsl:template name="vb-result">
    <div class="results">
	<xsl:for-each select="res:results/res:result">
	  <xsl:variable name="uri" select="normalize-space(./res:binding[@name='uri'])" />
	  <xsl:variable name="prevuri" select="normalize-space(preceding-sibling::*[1]/res:binding[@name='uri'])" />
	  <xsl:choose>
	    <xsl:when test="$uri != $prevuri">
	      <xsl:call-template name="result-head" />
	    </xsl:when>
	    <xsl:otherwise>
	      <xsl:call-template name="result-item" />
	    </xsl:otherwise>
	  </xsl:choose>
	</xsl:for-each>
    </div>
  </xsl:template>
  
  <xsl:template name="result-head">
    <hr />
    <xsl:variable name="current" select="."/>
    <xsl:variable name="type" select="normalize-space($current/res:binding[@name='type'])" />
    <xsl:choose>
      <xsl:when test="$type = 'http://www.movieontology.org/2009/10/01/movieontology.owl#Actor'">
        <xsl:call-template name="actor-result" />
      </xsl:when>
      <xsl:when test="$type = 'http://www.movieontology.org/2009/10/01/movieontology.owl#Movie'">
        <xsl:call-template name="movie-result" />
      </xsl:when>
      <xsl:when test="$type = 'http://www.movieontology.org/2009/10/01/movieontology.owl#Genre'">
        <xsl:call-template name="genre-result" />
      </xsl:when>
    </xsl:choose>
  </xsl:template>
  
  <xsl:template name="result-item">
    <xsl:variable name="current" select="."/>
    <xsl:variable name="type" select="normalize-space($current/res:binding[@name='type'])" />
    <xsl:choose>
      <xsl:when test="$type = 'http://www.movieontology.org/2009/10/01/movieontology.owl#Movie'">
        <xsl:call-template name="actor-item" />
      </xsl:when>
      <xsl:when test="$type = 'http://www.movieontology.org/2009/10/01/movieontology.owl#Actor'">
        <xsl:call-template name="movie-item" />
      </xsl:when>
      <xsl:when test="$type = 'http://www.movieontology.org/2009/10/01/movieontology.owl#Genre'">
        <xsl:call-template name="movie-item" />
      </xsl:when>
    </xsl:choose>
  </xsl:template>

  <xsl:template name="movie-item">
    <xsl:variable name="movie" select="normalize-space(./res:binding[@name='movie'])" />
    <p><xsl:value-of select="$movie" /></p>
  </xsl:template>

  <xsl:template name="actor-item">
    <xsl:variable name="actor" select="normalize-space(./res:binding[@name='actor'])" />
    <p><xsl:value-of select="$actor" /></p>
  </xsl:template>
  
  <xsl:template name="actor-result">
    <xsl:variable name="name" select="normalize-space(./res:binding[@name='desc'])" />
    <div class="result actor">
      <p><strong><a href="?query={$name}"><xsl:value-of select="$name" /></a></strong> is an actor who was born on <em><xsl:value-of select="normalize-space(./res:binding[@name='birthDate'])" /></em>.</p>
      <h3>Starring in</h3>
      <xsl:call-template name="movie-item" />
    </div>
  </xsl:template>
  
  <xsl:template name="movie-result">
    <xsl:variable name="name" select="normalize-space(./res:binding[@name='desc'])" />
    <div class="result movie">
      <p><strong><a href="?query={$name}"><xsl:value-of select="$name" /></a></strong> is a movie of the genre <em><xsl:value-of select="normalize-space(./res:binding[@name='genre'])" /></em>.</p>
      <h3>Cast</h3>
      <xsl:call-template name="actor-item" />
    </div>
  </xsl:template>
  
  <xsl:template name="genre-result">
    <xsl:variable name="name" select="normalize-space(./res:binding[@name='desc'])" />
    <div class="result actor">
      <p><strong><a href="?query={$name}"><xsl:value-of select="$name" /></a></strong> is a movie genre.</p>
      <h3>Movies</h3>
      <xsl:call-template name="movie-item" />
    </div>
  </xsl:template>

  <xsl:template match="res:bnode">
    <xsl:text>_:</xsl:text>
    <xsl:value-of select="text()"/>
  </xsl:template>

  <xsl:template match="res:uri">
    <!-- Roughly: SELECT ($uri AS ?subject) ?predicate ?object { $uri ?predicate ?object } -->
    <!-- XSLT 2.0
    <xsl:variable name="x"><xsl:value-of select="fn:encode-for-uri(.)"/></xsl:variable>
    -->
    <xsl:variable name="x"><xsl:value-of select="."/></xsl:variable>
    <!--
    <xsl:variable name="query">SELECT%20%28%3C<xsl:value-of select="."/>%3E%20AS%20%3Fsubject%29%20%3Fpredicate%20%3Fobject%20%7B%3C<xsl:value-of select="."/>%3E%20%3Fpredicate%20%3Fobject%20%7D</xsl:variable>
    -->
    <!--
     <xsl:variable name="query">SELECT%20%28%3C<xsl:value-of select="$x"/>%3E%20AS%20%3Fsubject%29%20%3Fpredicate%20%3Fobject%20%7B%3C<xsl:value-of select="$x"/>%3E%20%3Fpredicate%20%3Fobject%20%7D</xsl:variable>
    -->
     <xsl:variable name="query"><xsl:value-of select="$x"/></xsl:variable>
    <xsl:text>&lt;</xsl:text>
    <!--<a href="?query={$query}&amp;output=xml&amp;stylesheet=%2Fxml-to-html-links.xsl">-->
    <a href="?query={$query}">
    <xsl:value-of select="$x"/>
    </a>
    <xsl:text>&gt;</xsl:text>
  </xsl:template>

  <xsl:template match="res:literal">
    <xsl:text>"</xsl:text>
    <xsl:value-of select="text()"/>
    <xsl:text>"</xsl:text>

    <xsl:choose>
      <xsl:when test="@datatype">
        <!-- datatyped literal value -->
        ^^&lt;<xsl:value-of select="@datatype"/>&gt;
      </xsl:when>
      <xsl:when test="@xml:lang">
        <!-- lang-string -->
        @<xsl:value-of select="@xml:lang"/>
      </xsl:when>
    </xsl:choose>
  </xsl:template>

  <xsl:template match="res:sparql">
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
      <head>
        <title>Semantic Search</title>
        <link rel="stylesheet" type="text/css" media="all" href="search.css" />
      </head>
      <body>
        <h1>Movie Query Engine</h1>
        <form method="get">
            <div class="formbody">
                <input name="query" type="search" required="required" placeholder="Search for a movie, actor or genre. Or enter SPARQL directly like 'SELECT […]'"<?php if (isset($urlParam)) { echo ' value="' . str_replace('{', '{{', str_replace('}', '}}', htmlspecialchars($query))) . '"'; } ?> />
                <input type="submit" value="Query" />
            </div>
        </form>
        <h2>Results</h2>

	<xsl:if test="res:head/res:link">
	  <xsl:call-template name="header"/>
	</xsl:if>

	<xsl:choose>
	  <xsl:when test="res:boolean">
	    <xsl:call-template name="boolean-result" />
	  </xsl:when>

	  <xsl:when test="res:results">
	    <xsl:call-template name="vb-result" />
	  </xsl:when>

	</xsl:choose>


      </body>
    </html>
  </xsl:template>
</xsl:stylesheet>
