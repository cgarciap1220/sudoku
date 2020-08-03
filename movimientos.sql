USE [sudoku]
GO

/****** Object:  Table [dbo].[movimientos]    Script Date: 2/08/2020 08:07:33 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[movimientos](
	[idMovimiento] [int] IDENTITY(1,1) NOT NULL,
	[movInicial] [xml] NOT NULL,
	[movFinal] [xml] NOT NULL,
	[idResultado] [int] NOT NULL,
 CONSTRAINT [PK_movimientos] PRIMARY KEY CLUSTERED 
(
	[idMovimiento] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO

ALTER TABLE [dbo].[movimientos]  WITH CHECK ADD  CONSTRAINT [FK_movimientos_resultado] FOREIGN KEY([idResultado])
REFERENCES [dbo].[resultado] ([idResultado])
ON UPDATE CASCADE
ON DELETE CASCADE
GO

ALTER TABLE [dbo].[movimientos] CHECK CONSTRAINT [FK_movimientos_resultado]
GO


