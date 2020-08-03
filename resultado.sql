USE [sudoku]
GO

/****** Object:  Table [dbo].[resultado]    Script Date: 2/08/2020 08:07:45 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[resultado](
	[idResultado] [int] IDENTITY(1,1) NOT NULL,
	[matrix] [xml] NOT NULL,
 CONSTRAINT [PK_resultado] PRIMARY KEY CLUSTERED 
(
	[idResultado] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO


