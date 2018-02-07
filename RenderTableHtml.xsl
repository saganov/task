<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
 <html>
   <head>
       <style type="text/css">
        table {table-layout:fixed; width: 300px; height: 300px;}
        table td {width: 30px; height: 30px; border: 1px solid #000}
     </style>
   </head>
  <body>
  <h2>Test task #1</h2>
    <table border="1">
    <xsl:for-each select="table/row">
      <tr>
      <xsl:for-each select="cell">
        <td>
			<xsl:if test="align">	
				<xsl:attribute name="align">
					<xsl:value-of select="align" />
				</xsl:attribute>
			</xsl:if>
			<xsl:if test="valign">	
				<xsl:attribute name="valign">
					<xsl:value-of select="valign" />
				</xsl:attribute>
			</xsl:if>
			<xsl:if test="bgcolor">	
				<xsl:attribute name="bgcolor">
					<xsl:value-of select="bgcolor" />
				</xsl:attribute>
			</xsl:if>
			<xsl:if test="color">
      			<xsl:attribute name="style">
				    <xsl:text>color:#</xsl:text><xsl:value-of select="color" /><xsl:text>;</xsl:text>
			    </xsl:attribute>
			</xsl:if>
			<xsl:if test="rowspan">	
				<xsl:attribute name="rowspan">
					<xsl:value-of select="rowspan" />
				</xsl:attribute>
			</xsl:if>
			<xsl:if test="colspan">	
				<xsl:attribute name="colspan">
					<xsl:value-of select="colspan" />
				</xsl:attribute>
			</xsl:if>
			<xsl:value-of select="text"/>
		</td>
      </xsl:for-each>
      </tr>
    </xsl:for-each>
    </table>
  </body>
  </html>
</xsl:template>
</xsl:stylesheet>
