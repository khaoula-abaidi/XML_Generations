<?xml version="1.0"?>
<xsl:stylesheet
        version = "1.0"
        xmlns:xsl ="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html"
            encoding="UTF-8"
            doctype-public="-//W3C//DTD HTML 4.01/EN"
            doctype-system="http://www.w3.org/TR/html4/strict.dtd"
            indent="yes"
/>
<xsl:template match="/">
   <html>
       <head>
           <title>
               Type de téléphone et numéro de marie
           </title>
       </head>
       <body>
           <p>Type de numéro: 
               <xsl:value-of
                       select="repertoire/personne[nom='POPPINS']/telephones/telephone/@type" />
           </p>
           <p>Numéro:
               <xsl:value-of
                       select="repertoire/personne[nom='POPPINS']/telephones/telephone"/>
           </p>
       </body>
   </html> 
</xsl:template>
<xsl:template match="/">
    <html>
        <head>
            <title>Type emails de joe</title>
        </head>
        <body>
            <xsl:for-each select="repertoire/personne[nom='DOE']/emails/email">
                    <p>Type de l'addresse email:
                        <xsl:value-of select="@type"/>
                    </p>
                <p>adresse email :
                    <xsl:value-of select="."/>
                </p>
            </xsl:for-each>
        </body>
    </html>
</xsl:template>
<xsl:template match="/">
    <html>
        <head><title>Par ordre alpabetique</title>
        </head>
        <body>
            <xsl:for-each select="repertoire/personne">
                <xsl:sort  select="nom"/>
                <xsl:sort  select="prenom"/>
                <p>
                    <xsl:value-of select="nom"/>&#160;
                    <xsl:value-of select="prenom"/>
                </p>
            </xsl:for-each>
        </body>
    </html>
</xsl:template>
<xsl:template match="/">
        <html>
            <head>
            <title>nom et personne masculin</title>
            </head>
            <body>
                <xsl:for-each select="repertoire/personne">
                    <xsl:if test="@sexe='feminin'">
                        <p>Nom : <xsl:value-of select="nom"/>
                        </p>
                        <p>Préom : <xsl:value-of select="prenom"/>
                        </p>
                    </xsl:if>
                </xsl:for-each>
            </body>
        </html>
</xsl:template>
 <xsl:template match="/">
        <html>
            <head>
                <title>reponse par nom et personne</title>
            </head>
            <body>
                <xsl:for-each select="repertoire/personne">
                    <xsl:choose>
                        <xsl:when test="nom='DOE'">
                            <p>
                                Bonjour <xsl:value-of select="prenom"/>
                            </p>
                        </xsl:when>
                        <xsl:when test="nom='POPPINS'">
                            <p>
                                Quel age as tu  <xsl:value-of select="prenom"/> ?
                            </p>
                        </xsl:when>
                        <xsl:otherwise>
                            <p>
                                Tu vas passé par le secrétariat <xsl:value-of select="prenom"/>
                            </p>
                        </xsl:otherwise>
                    </xsl:choose>
                </xsl:for-each>
            </body>
        </html>
</xsl:template>
</xsl:stylesheet>