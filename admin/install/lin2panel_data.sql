USE [lin2panel]
GO

SET IDENTITY_INSERT [dbo].[account] ON
INSERT INTO [account] ([uid],[account],[password],[language])VALUES(1,'admin',0x21232f297a57a5a743894a0e4a801fc3,'en')
SET IDENTITY_INSERT [dbo].[account] OFF

SET IDENTITY_INSERT [dbo].[account_privileges] ON
INSERT INTO [account_privileges] ([id],[uid],[page],[privilege])VALUES(1,1,'p=1','3')
INSERT INTO [account_privileges] ([id],[uid],[page],[privilege])VALUES(2,1,'p=2','3')
INSERT INTO [account_privileges] ([id],[uid],[page],[privilege])VALUES(3,1,'p=3','3')
INSERT INTO [account_privileges] ([id],[uid],[page],[privilege])VALUES(4,1,'p=4','3')
INSERT INTO [account_privileges] ([id],[uid],[page],[privilege])VALUES(5,1,'p=5','3')
INSERT INTO [account_privileges] ([id],[uid],[page],[privilege])VALUES(6,1,'p=6','3')
INSERT INTO [account_privileges] ([id],[uid],[page],[privilege])VALUES(7,1,'p=7','3')
INSERT INTO [account_privileges] ([id],[uid],[page],[privilege])VALUES(8,1,'p=8','3')
INSERT INTO [account_privileges] ([id],[uid],[page],[privilege])VALUES(9,1,'p=9','3')
INSERT INTO [account_privileges] ([id],[uid],[page],[privilege])VALUES(10,1,'p=10','3')
INSERT INTO [account_privileges] ([id],[uid],[page],[privilege])VALUES(11,1,'p=11','3')
INSERT INTO [account_privileges] ([id],[uid],[page],[privilege])VALUES(12,1,'p=12','3')
SET IDENTITY_INSERT [dbo].[account_privileges] OFF
