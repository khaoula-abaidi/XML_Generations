<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" indent="yes"/>
    <xsl:template match="/persons">
        <root>
            <xsl:apply-templates select="person"/>
        </root>
    </xsl:template>
    <xsl:template match="person">
        <name username ="{@username}">
            <xsl:value-of select="name" />
        </name>
    </xsl:template>
</xsl:stylesheet>