/****** Object:  Database [lin2panel]    Script Date: 12/18/2006 20:46:38 ******/
CREATE DATABASE [lin2panel] ON PRIMARY
( NAME = N'lin2panel_Data', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL10_50.MSSQLSERVER\MSSQL\DATA\lin2panel_Data.MDF' , MAXSIZE = UNLIMITED, FILEGROWTH = 10%)
 LOG ON
( NAME = N'lin2panel_Log', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL10_50.MSSQLSERVER\MSSQL\DATA\lin2panel_Log.LDF' , MAXSIZE = UNLIMITED, FILEGROWTH = 10%)
 COLLATE Latin1_General_CI_AS
GO
EXEC dbo.sp_dbcmptlevel @dbname=N'lin2panel', @new_cmptlevel=90
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [lin2panel].[dbo].[sp_fulltext_database] @action = 'disable'
end
GO
USE [lin2panel]
GO
/****** Object:  Table [dbo].[donation_set]    Script Date: 05/19/2007 12:09:04 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[donation_set]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[donation_set](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](50) NOT NULL,
	[create_date] [datetime] NOT NULL CONSTRAINT [DF_donation_set_create_date]  DEFAULT (getdate()),
	[modify_date] [datetime] NOT NULL CONSTRAINT [DF_donation_set_modify_date]  DEFAULT (getdate()),
	[status] [tinyint] NOT NULL CONSTRAINT [DF_donation_set_status]  DEFAULT ((0)),
 CONSTRAINT [PK_donation_set] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, IGNORE_DUP_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
END
GO
/****** Object:  Table [dbo].[account]    Script Date: 05/19/2007 12:09:04 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[account]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[account](
	[uid] [int] IDENTITY(1,1) NOT NULL,
	[account] [nvarchar](50) NOT NULL,
	[password] [binary](16) NOT NULL CONSTRAINT [DF_account_password]  DEFAULT ((0)),
	[language] [nvarchar](3) NOT NULL CONSTRAINT [DF_account_language]  DEFAULT (N'en'),
 CONSTRAINT [PK_account_id] PRIMARY KEY NONCLUSTERED 
(
	[uid] ASC
)WITH (PAD_INDEX  = OFF, IGNORE_DUP_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
END
GO

/****** Object:  Index [IX_account_name]    Script Date: 05/19/2007 12:09:04 ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[account]') AND name = N'IX_account_name')
CREATE CLUSTERED INDEX [IX_account_name] ON [dbo].[account] 
(
	[account] ASC
)WITH (PAD_INDEX  = OFF, IGNORE_DUP_KEY = OFF) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[account_privileges]    Script Date: 05/19/2007 12:09:04 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[account_privileges]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[account_privileges](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[uid] [int] NOT NULL,
	[page] [nvarchar](200) NOT NULL,
	[privilege] [nvarchar](50) NOT NULL,
 CONSTRAINT [PK_account_privileges_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, IGNORE_DUP_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
END
GO
/****** Object:  Table [dbo].[donation_log]    Script Date: 05/19/2007 12:09:04 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[donation_log]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[donation_log](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[set_id] [int] NOT NULL,
	[account_id] [int] NOT NULL,
	[account_name] [nvarchar](50) NOT NULL,
	[char_id] [int] NOT NULL,
	[char_name] [nvarchar](50) NOT NULL,
	[amount] [int] NOT NULL,
	[log_date] [datetime] NOT NULL CONSTRAINT [DF_donation_log_log_date_1]  DEFAULT (getdate()),
	[status] [tinyint] NOT NULL CONSTRAINT [DF_donation_log_status]  DEFAULT ((0)),
 CONSTRAINT [PK_donation_log] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, IGNORE_DUP_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
END
GO

/****** Object:  Index [IX_donation_log_account_id]    Script Date: 05/19/2007 12:09:04 ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[donation_log]') AND name = N'IX_donation_log_account_id')
CREATE NONCLUSTERED INDEX [IX_donation_log_account_id] ON [dbo].[donation_log] 
(
	[account_id] ASC
)WITH (PAD_INDEX  = OFF, IGNORE_DUP_KEY = OFF) ON [PRIMARY]
GO

/****** Object:  Index [IX_donation_log_char_id]    Script Date: 05/19/2007 12:09:04 ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[donation_log]') AND name = N'IX_donation_log_char_id')
CREATE NONCLUSTERED INDEX [IX_donation_log_char_id] ON [dbo].[donation_log] 
(
	[char_id] ASC
)WITH (PAD_INDEX  = OFF, IGNORE_DUP_KEY = OFF) ON [PRIMARY]
GO

/****** Object:  Index [IX_donation_log_set_id]    Script Date: 05/19/2007 12:09:04 ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[donation_log]') AND name = N'IX_donation_log_set_id')
CREATE NONCLUSTERED INDEX [IX_donation_log_set_id] ON [dbo].[donation_log] 
(
	[set_id] ASC
)WITH (PAD_INDEX  = OFF, IGNORE_DUP_KEY = OFF) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[donation_set_item]    Script Date: 05/19/2007 12:09:04 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[donation_set_item]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[donation_set_item](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[set_id] [int] NOT NULL,
	[item_type] [int] NOT NULL,
	[amount] [int] NOT NULL CONSTRAINT [DF_donation_set_item_amount]  DEFAULT ((0)),
	[divider] [int] NOT NULL CONSTRAINT [DF_donation_set_item_divider]  DEFAULT ((1)),
	[condition] [int] NOT NULL CONSTRAINT [DF_donation_set_item_condition]  DEFAULT ((0)),
	[create_date] [datetime] NOT NULL CONSTRAINT [DF_donation_set_item_create_date]  DEFAULT (getdate()),
	[modify_date] [datetime] NOT NULL CONSTRAINT [DF_donation_set_item_modify_date]  DEFAULT (getdate()),
	[status] [tinyint] NOT NULL CONSTRAINT [DF_donation_set_item_status]  DEFAULT ((0)),
 CONSTRAINT [PK_donation_set_item] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, IGNORE_DUP_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
END
GO

/****** Object:  Index [IX_donation_set_id]    Script Date: 05/19/2007 12:09:04 ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[donation_set_item]') AND name = N'IX_donation_set_id')
CREATE NONCLUSTERED INDEX [IX_donation_set_id] ON [dbo].[donation_set_item] 
(
	[set_id] ASC
)WITH (PAD_INDEX  = OFF, IGNORE_DUP_KEY = OFF) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[donation_log_item]    Script Date: 05/19/2007 12:09:04 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[donation_log_item]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[donation_log_item](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[log_id] [int] NOT NULL,
	[set_id] [int] NOT NULL,
	[set_item_id] [int] NOT NULL,
	[account_id] [int] NOT NULL,
	[char_id] [int] NOT NULL,
	[item_type] [int] NOT NULL,
	[amount] [int] NOT NULL,
	[log_date] [datetime] NOT NULL CONSTRAINT [DF_donation_log_log_date]  DEFAULT (getdate()),
	[status] [tinyint] NOT NULL CONSTRAINT [DF_donation_log_item_status]  DEFAULT ((0)),
 CONSTRAINT [PK_donation_log_item] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, IGNORE_DUP_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
END
GO

/****** Object:  Index [IX_donation_log_item_char_id]    Script Date: 05/19/2007 12:09:04 ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[donation_log_item]') AND name = N'IX_donation_log_item_char_id')
CREATE NONCLUSTERED INDEX [IX_donation_log_item_char_id] ON [dbo].[donation_log_item] 
(
	[char_id] ASC
)WITH (PAD_INDEX  = OFF, IGNORE_DUP_KEY = OFF) ON [PRIMARY]
GO

/****** Object:  Index [IX_donation_log_item_log_id]    Script Date: 05/19/2007 12:09:04 ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[donation_log_item]') AND name = N'IX_donation_log_item_log_id')
CREATE NONCLUSTERED INDEX [IX_donation_log_item_log_id] ON [dbo].[donation_log_item] 
(
	[log_id] ASC
)WITH (PAD_INDEX  = OFF, IGNORE_DUP_KEY = OFF) ON [PRIMARY]
GO

/****** Object:  Index [IX_donation_log_item_set_id]    Script Date: 05/19/2007 12:09:04 ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[donation_log_item]') AND name = N'IX_donation_log_item_set_id')
CREATE NONCLUSTERED INDEX [IX_donation_log_item_set_id] ON [dbo].[donation_log_item] 
(
	[set_id] ASC,
	[set_item_id] ASC
)WITH (PAD_INDEX  = OFF, IGNORE_DUP_KEY = OFF) ON [PRIMARY]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[FK_account_privileges_account]') AND parent_object_id = OBJECT_ID(N'[dbo].[account_privileges]'))
ALTER TABLE [dbo].[account_privileges]  WITH CHECK ADD  CONSTRAINT [FK_account_privileges_account] FOREIGN KEY([uid])
REFERENCES [dbo].[account] ([uid])
GO
ALTER TABLE [dbo].[account_privileges] CHECK CONSTRAINT [FK_account_privileges_account]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[FK_donation_log_donation_set]') AND parent_object_id = OBJECT_ID(N'[dbo].[donation_log]'))
ALTER TABLE [dbo].[donation_log]  WITH CHECK ADD  CONSTRAINT [FK_donation_log_donation_set] FOREIGN KEY([set_id])
REFERENCES [dbo].[donation_set] ([id])
GO
ALTER TABLE [dbo].[donation_log] CHECK CONSTRAINT [FK_donation_log_donation_set]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[FK_donation_set]') AND parent_object_id = OBJECT_ID(N'[dbo].[donation_set_item]'))
ALTER TABLE [dbo].[donation_set_item]  WITH CHECK ADD  CONSTRAINT [FK_donation_set] FOREIGN KEY([set_id])
REFERENCES [dbo].[donation_set] ([id])
GO
ALTER TABLE [dbo].[donation_set_item] CHECK CONSTRAINT [FK_donation_set]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[FK_donation_log_item_donation_log]') AND parent_object_id = OBJECT_ID(N'[dbo].[donation_log_item]'))
ALTER TABLE [dbo].[donation_log_item]  WITH CHECK ADD  CONSTRAINT [FK_donation_log_item_donation_log] FOREIGN KEY([log_id])
REFERENCES [dbo].[donation_log] ([id])
GO
ALTER TABLE [dbo].[donation_log_item] CHECK CONSTRAINT [FK_donation_log_item_donation_log]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[FK_donation_log_item_donation_set]') AND parent_object_id = OBJECT_ID(N'[dbo].[donation_log_item]'))
ALTER TABLE [dbo].[donation_log_item]  WITH CHECK ADD  CONSTRAINT [FK_donation_log_item_donation_set] FOREIGN KEY([set_id])
REFERENCES [dbo].[donation_set] ([id])
GO
ALTER TABLE [dbo].[donation_log_item] CHECK CONSTRAINT [FK_donation_log_item_donation_set]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[FK_donation_log_item_donation_set_item]') AND parent_object_id = OBJECT_ID(N'[dbo].[donation_log_item]'))
ALTER TABLE [dbo].[donation_log_item]  WITH CHECK ADD  CONSTRAINT [FK_donation_log_item_donation_set_item] FOREIGN KEY([set_item_id])
REFERENCES [dbo].[donation_set_item] ([id])
GO
ALTER TABLE [dbo].[donation_log_item] CHECK CONSTRAINT [FK_donation_log_item_donation_set_item]
