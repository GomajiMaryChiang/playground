@extends('modules.common')

@section('content')
    <main class="main">
        <div class="sectionBox">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                        <div class="thirdparty">
                            <div class="d-flex justify-content-center mb-3">
                                <div class="gomaji-logo">
                                    <img width="160px"
                                        src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyB3aWR0aD0iMTYxcHgiIGhlaWdodD0iNTRweCIgdmlld0JveD0iMCAwIDE2MSA1NCIgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj4KICAgIDx0aXRsZT5Mb2dvPC90aXRsZT4KICAgIDxnIGlkPSJTeW1ib2xzIiBzdHJva2U9Im5vbmUiIHN0cm9rZS13aWR0aD0iMSIgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj4KICAgICAgICA8ZyBpZD0iSGVhZGVyL0hlYWRlci1Db3B5IiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtMTQ5LjAwMDAwMCwgLTU2LjAwMDAwMCkiIGZpbGw9IiNGRjg4MDAiPgogICAgICAgICAgICA8ZyBpZD0iTG9nbyIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTUwLjAwMDAwMCwgNTYuMDAwMDAwKSI+CiAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMTMuNDQ3MzExMyw0OC4zMTM2MzI2IEwxMC4yMzE0MTcyLDQ4LjMxMzYzMjYgQzEwLjU0OTI5OCw0OS4yMjc5ODU1IDExLjEwODc2ODIsNTAuMDMyMTEyMiAxMS45MDk4Mjc4LDUwLjcyNDk2MjkgQzEyLjYxNjU4MjgsNTAuMDAwNjE5IDEzLjEyOTQzMDUsNDkuMTk2NDkyMyAxMy40NDczMTEzLDQ4LjMxMzYzMjYgTDEzLjQ0NzMxMTMsNDguMzEzNjMyNiBaIE04LjU2OTk2MDI2LDQ4LjMxMzYzMjYgTDguNTY5OTYwMjYsNDcuMzg0NTgyOCBMMTQuNTk1OTIwNSw0Ny4zODQ1ODI4IEwxNC41OTU5MjA1LDQ4LjI2NzQ0MjUgQzE0LjI2NjM4NDEsNDkuNDY0MTg0NiAxMy42NzA4ODc0LDUwLjUwOTc1OTMgMTIuODExNTQ5Nyw1MS40MDIwNjcgQzEzLjU4OTI5OCw1MS45MTc1MDU5IDE0LjUxOTYyOTEsNTIuMzc5NDA2MyAxNS42MDM2MDI2LDUyLjc4ODgxODEgTDE0Ljk0OTgyNzgsNTMuNzM0NjY0MyBDMTMuNzcxNTQ5Nyw1My4yNDAyMjA4IDEyLjc4NzE3ODgsNTIuNzA0ODM2MiAxMS45OTg4MzQ0LDUyLjEyNzQ2MDYgQzExLjE4NjExOTIsNTIuNzU3MzI0OSAxMC4yMDE3NDgzLDUzLjI5Mzc1OTMgOS4wNDc4NDEwNiw1My43MzQ2NjQzIEw4LjM5MzAwNjYyLDUyLjg1MTgwNDUgQzkuNTAwMjkxMzksNTIuNDIxMzk3MyAxMC40MTM2Njg5LDUxLjkzODUwMTQgMTEuMTMyMDc5NSw1MS40MDIwNjcgQzEwLjE1NTEyNTgsNTAuNDk5MjYxNSA5LjQ4OTY5NTM2LDQ5LjQ3MDQ4MzMgOS4xMzU3ODgwOCw0OC4zMTM2MzI2IEw4LjU2OTk2MDI2LDQ4LjMxMzYzMjYgWiBNMy40NjI2NzU1LDQzLjU1NjA1NzkgTDEyLjE5Mjc0MTcsNDMuNTU2MDU3OSBMMTIuMTkyNzQxNyw0Mi40OTk5ODU1IEwzLjQ2MjY3NTUsNDIuNDk5OTg1NSBMMy40NjI2NzU1LDQzLjU1NjA1NzkgWiBNMy40NjM3MzUxLDQxLjY5NTg1ODggTDEyLjE5MzgwMTMsNDEuNjk1ODU4OCBMMTIuMTkzODAxMyw0MC42ODgwNzYgTDMuNDYzNzM1MSw0MC42ODgwNzYgTDMuNDYzNzM1MSw0MS42OTU4NTg4IFogTTIuODQ0OTI3MTUsNTEuNzMzNzk1NSBDNC4xNzU3ODgwOCw1MS42NDk4MTM2IDUuMzY1NzIxODUsNTEuNTU1MzMzOSA2LjQxNDcyODQ4LDUxLjQ0OTMwNjggTDYuNDE0NzI4NDgsNTAuMzc4NTM3NiBMMi44NDQ5MjcxNSw1MC4zNzg1Mzc2IEwyLjg0NDkyNzE1LDUxLjczMzc5NTUgWiBNMi44NDQ5MjcxNSw0OS41NDI5MTc2IEw2LjQxNDcyODQ4LDQ5LjU0MjkxNzYgTDYuNDE0NzI4NDgsNDguMzYxOTIyMiBMMi44NDQ5MjcxNSw0OC4zNjE5MjIyIEwyLjg0NDkyNzE1LDQ5LjU0MjkxNzYgWiBNMi44NDQ5MjcxNSw0Ny41MTA1NTU3IEw2LjQxNDcyODQ4LDQ3LjUxMDU1NTcgTDYuNDE0NzI4NDgsNDYuMzI4NTEwNCBMMi44NDQ5MjcxNSw0Ni4zMjg1MTA0IEwyLjg0NDkyNzE1LDQ3LjUxMDU1NTcgWiBNMi4yNDQxMzI0NSw0NC4zNzU5MzEyIEwxMy40MTIzNDQ0LDQ0LjM3NTkzMTIgTDEzLjQxMjM0NDQsMzkuODM3NzU5MyBMMi4yNDQxMzI0NSwzOS44Mzc3NTkzIEwyLjI0NDEzMjQ1LDQ0LjM3NTkzMTIgWiBNLTAuMDAwMTA1OTYwMjY1LDQ1LjQxNTIwNzIgTDE1LjU4NTU4OTQsNDUuNDE1MjA3MiBMMTUuNTg1NTg5NCw0Ni4zMjg1MTA0IEw3LjY1MTI4NDc3LDQ2LjMyODUxMDQgTDcuNjUxMjg0NzcsNTEuMzA4NjM3MSBMOC42NzY5ODAxMyw1MS4xNjU4Njc5IEw4LjY3Njk4MDEzLDUyLjA2NDQ3NDIgTDcuNjUxMjg0NzcsNTIuMjIyOTkgTDcuNjUxMjg0NzcsNTMuNzUwNDEwOSBMNi40MTQ3Mjg0OCw1My43NTA0MTA5IEw2LjQxNDcyODQ4LDUyLjM2MjYxIEM0LjYzNTY1NTYzLDUyLjU0MjEyMTMgMi41NjgzNzA4Niw1Mi42OTUzODgyIDAuMjExODE0NTcsNTIuODIxMzYxMSBMMC4wNTI4NzQxNzIyLDUxLjg0Mjk3MTkgTDEuNjk2MzE3ODgsNTEuNzgxMDM1MyBMMS42OTYzMTc4OCw0Ni4zMjg1MTA0IEwtMC4wMDAxMDU5NjAyNjUsNDYuMzI4NTEwNCBMLTAuMDAwMTA1OTYwMjY1LDQ1LjQxNTIwNzIgWiIgaWQ9IkZpbGwtMSIgc3Ryb2tlPSIjRkY4ODAwIiBzdHJva2Utd2lkdGg9IjAuMiI+PC9wYXRoPgogICAgICAgICAgICAgICAgPHBhdGggZD0iTTIwLjg3MTUwOCw0My40MTQzMzg1IEwyNy43NDUxNTA0LDQzLjQxNDMzODUgQzI3Ljg3NTQ4MTYsNDIuNTQzMDI2MiAyNy45NTE3NzI5LDQxLjU5MTkzMTIgMjcuOTc1MDg0Miw0MC41NjIxMDMyIEwyNy45NzUwODQyLDM5LjI4NTU3ODMgTDI5LjI4MjYzMzksMzkuMjg1NTc4MyBMMjkuMjgyNjMzOSw0MC4zMTAxNTc1IEMyOS4yODI2MzM5LDQxLjMxODk5IDI5LjIwNjM0MjUsNDIuMzUzMDE3MiAyOS4wNTM3NTk3LDQzLjQxNDMzODUgTDM2LjM4NzI2OTYsNDMuNDE0MzM4NSBMMzYuMzg3MjY5Niw0NC41MTY2MDA5IEwyOS40MjQ2MjA2LDQ0LjUxNjYwMDkgQzMwLjY2MTE3NjksNDguMDc3NDMzNSAzMy4wOTQwMjQ2LDUwLjgxOTQ0MjUgMzYuNzIyMTA0MSw1Mi43NDI2MjgxIEwzNS45Mjc0MDIxLDUzLjY1NTkzMTIgQzMyLjM2OTI1NjQsNTEuNzAyMzAyMyAyOS45MzExMTA3LDQ4Ljk0OTc5NTUgMjguNjExOTA1NCw0NS40MDA1MTA0IEMyNy41MTYyNzYzLDQ5LjIyMjczNjcgMjUuMDgzNDI4Niw1Mi4wMTE5ODU1IDIxLjMxMzM2MjMsNTMuNzY2MTU3NSBMMjAuNTE4NjYwNCw1Mi44MjEzNjExIEMyNC4yNzYwMTE0LDUxLjE3MjE2NjUgMjYuNjE0NTU0NCw0OC40MDM5MTMxIDI3LjUzMzIyOTksNDQuNTE2NjAwOSBMMjAuODcxNTA4LDQ0LjUxNjYwMDkgTDIwLjg3MTUwOCw0My40MTQzMzg1IFoiIGlkPSJGaWxsLTQiIHN0cm9rZT0iI0ZGODgwMCIgc3Ryb2tlLXdpZHRoPSIwLjIiPjwvcGF0aD4KICAgICAgICAgICAgICAgIDxwYXRoIGQ9Ik00OC4zMTY4OTY5LDQ0LjgxNjgzNjIgTDU1LjEzNzU1OTEsNDQuODE2ODM2MiBMNTUuMTM3NTU5MSw0NS44MjQ2MTkgQzUzLjUwMDQ3Myw0Ny4yMjE4Njc5IDUyLjI3NDUxMjgsNDguMzQ2MTc1NiA1MS40NjE3OTc1LDQ5LjE5NjQ5MjMgQzUwLjY4NTEwODgsNDkuOTg0ODcyNCA1MC4xNDg5NDk5LDUwLjU5Mzc0MTIgNDkuODU0MzgwMyw1MS4wMjQxNDg0IEM0OS41NzE0NjY0LDUxLjQxMzYxNDUgNDkuNDMwNTM5Myw1MS43MDY1MDE0IDQ5LjQzMDUzOTMsNTEuOTA3MDA4MSBDNDkuNDMwNTM5Myw1Mi4yNjM5MzEyIDQ5LjcxODc1MTIsNTIuNDQyMzkyOCA1MC4yOTYyMzQ2LDUyLjQ0MjM5MjggTDU0LjE4MzkxNjcsNTIuNDQyMzkyOCBDNTQuNjU0MzgwMyw1Mi40NDIzOTI4IDU1LjAxOTk0MzIsNTIuMzExMTcxIDU1LjI3OTU0NTksNTIuMDQ4NzI3NiBDNTUuNTE0Nzc3Nyw1MS43NzU3ODY0IDU1LjY4NTM3MzcsNTAuOTA5NzIzMSA1NS43OTEzMzQsNDkuNDQ5NDg3OCBMNTYuOTc0OTEwMSw0OS44MjYzNTY2IEM1Ni44MzM5ODMsNTEuNTQ5MDM1MyA1Ni41NDU3NzExLDUyLjU4OTM2MTEgNTYuMTA5MjE0OCw1Mi45NDYyODQyIEM1NS42OTcwMjkzLDUzLjI4MjIxMTggNTUuMDU0OTEwMSw1My40NjA2NzMzIDU0LjE4MzkxNjcsNTMuNDgyNzE4NiBMNDkuOTk1MzA3NSw1My40ODI3MTg2IEM0OC42OTk0MTM0LDUzLjQ4MjcxODYgNDguMDUxOTk2Miw1My4wMjUwMTcyIDQ4LjA1MTk5NjIsNTIuMTExNzE0IEM0OC4wNTE5OTYyLDUxLjc3NTc4NjQgNDguMjEwOTM2Niw1MS40MDIwNjcgNDguNTI4ODE3NCw1MC45OTM3MDUgQzQ4LjgzNTA0MjYsNTAuNDk5MjYxNSA0OS40NTM4NTA1LDQ5Ljc2NDQxOTkgNTAuMzg0MTgxNiw0OC43ODcwODA1IEM1MS4yNjc4OTAzLDQ3Ljg0MTIzNDQgNTIuMjYyODU3MSw0Ni44NzU0NDI1IDUzLjM3MTIwMTUsNDUuODg4NjU1MiBMNDguMzE2ODk2OSw0NS44ODg2NTUyIEw0OC4zMTY4OTY5LDQ0LjgxNjgzNjIgWiBNNDkuMTQ3NjI1NCw0Mi40MzY5OTkxIEM0OC42NDExMzUzLDQzLjE5Mzg4NiA0OC4wODA2MDU1LDQzLjg4MTQ4NzggNDcuNDY4MTU1Miw0NC41MDE5MDQxIEw0Ni42Mzg0ODYzLDQzLjYzNDc5MSBDNDcuODA0MDQ5Miw0Mi40OTk5ODU1IDQ4Ljc1ODc1MTIsNDEuMDMwMzAyMyA0OS41MDA0NzMsMzkuMjIzNjQxNiBMNTAuNjg1MTA4OCwzOS40NTg3OTEgQzUwLjM1NDUxMjgsNDAuMjQ2MTIxMyA1MC4wNTk5NDMyLDQwLjg3MjgzNjIgNDkuODAxNDAwMiw0MS4zMzQ3MzY3IEw1Ni42MDQwNDkyLDQxLjMzNDczNjcgTDU2LjYwNDA0OTIsNDIuNDM2OTk5MSBMNDkuMTQ3NjI1NCw0Mi40MzY5OTkxIFogTTQyLjg3MzcxODEsNTAuMDc5MzUyIEw0NS4xODg5NDk5LDUwLjA3OTM1MiBMNDUuMTg4OTQ5OSw0MS42MzM5MjIyIEw0Mi44NzM3MTgxLDQxLjYzMzkyMjIgTDQyLjg3MzcxODEsNTAuMDc5MzUyIFogTTQ2LjQwODU1MjUsNDAuNTYyMTAzMiBMNDYuNDA4NTUyNSw1Mi4xMTE3MTQgTDQ1LjE4ODk0OTksNTIuMTExNzE0IEw0NS4xODg5NDk5LDUxLjE1MDEyMTMgTDQyLjg3MzcxODEsNTEuMTUwMTIxMyBMNDIuODczNzE4MSw1Mi40OTA2ODI0IEw0MS42MzcxNjE4LDUyLjQ5MDY4MjQgTDQxLjYzNzE2MTgsNDAuNTYyMTAzMiBMNDYuNDA4NTUyNSw0MC41NjIxMDMyIFoiIGlkPSJGaWxsLTciIHN0cm9rZT0iI0ZGODgwMCIgc3Ryb2tlLXdpZHRoPSIwLjIiPjwvcGF0aD4KICAgICAgICAgICAgICAgIDxwYXRoIGQ9Ik03MC40MDgxMTM1LDUwLjQ4ODAyOSBMNjkuNzcxMjkyMyw0OS43Nzk0MzE3IEM3MC44NDM2MTAyLDQ5LjE0OTU2NzQgNzEuNTc0NzM2LDQ4LjI5OTI1MDcgNzEuOTYyNTUwNiw0Ny4yMjc0MzE3IEw3Mi45NzAyMzI3LDQ3LjM2ODEwMTQgQzcyLjg1MjYxNjgsNDcuNzE0NTI2NyA3Mi43MTA2MzAxLDQ4LjAzMDUwODYgNzIuNTQ2MzkxNyw0OC4zMTM5NDc1IEM3My4zNDc0NTEzLDQ4LjY4MTM2ODMgNzQuMTEyNDg0NCw0OS4xMzM4MjA4IDc0Ljg0MzYxMDIsNDkuNjY5MjA1NCBMNzQuMjU5NzY5Miw1MC40ODgwMjkgQzczLjU2NDY2OTgsNDkuOTMxNjQ4OSA3Mi44MjkzMDU2LDQ5LjQ1NTA1MTYgNzIuMDUxNTU3Miw0OS4wNTUwODc4IEM3MS42MTUwMDA5LDQ5LjYxMTQ2NzkgNzEuMDY4MjQ2LDUwLjA4OTExNDkgNzAuNDA4MTEzNSw1MC40ODgwMjkgTDcwLjQwODExMzUsNTAuNDg4MDI5IFogTTY5LjI5NDQ3MTEsNDMuOTE3NDk1IEw3NC43MDE2MjM1LDQzLjkxNzQ5NSBMNzQuNzAxNjIzNSw0Mi43MzY0OTk1IEw2OS4yOTQ0NzExLDQyLjczNjQ5OTUgTDY5LjI5NDQ3MTEsNDMuOTE3NDk1IFogTTY5LjI5NDQ3MTEsNDEuOTAwODc5NiBMNzQuNzAxNjIzNSw0MS45MDA4Nzk2IEw3NC43MDE2MjM1LDQwLjY4ODM5MSBMNjkuMjk0NDcxMSw0MC42ODgzOTEgTDY5LjI5NDQ3MTEsNDEuOTAwODc5NiBaIE02OC4wNzQ4Njg1LDQ4LjA5NDU0NDggTDY5LjI0MTQ5MSw0OC4wOTQ1NDQ4IEw2OS4yNDE0OTEsNTEuMDU1OTU2NiBMNzMuNzQ3OTgxMSw1MS4wNTU5NTY2IEw3My43NDc5ODExLDUyLjAwMDc1MjkgTDY4LjA3NDg2ODUsNTIuMDAwNzUyOSBMNjguMDc0ODY4NSw0OC4wOTQ1NDQ4IFogTTY4LjE0NTg2MTksMzkuNzkwODM0NCBMNzUuODUwMjMyNywzOS43OTA4MzQ0IEw3NS44NTAyMzI3LDQ0LjgzMTg0OCBMNzAuNjAyMDIwOCw0NC44MzE4NDggQzcwLjQxMzQxMTUsNDUuMTc4MjczMyA3MC4yMDc4NDg2LDQ1LjUyMTU0OTMgNjkuOTg0MjcyNSw0NS44NTY0MjcxIEw3Ni44Mzk5MDE2LDQ1Ljg1NjQyNzEgQzc2Ljc2ODkwODIsNDkuNDgwMjQ2MiA3Ni42NzU2NjMyLDUxLjU3NTU5NDYgNzYuNTU2OTg3Nyw1Mi4xNDM1MjIyIEM3Ni40MTYwNjA1LDUyLjc1MjM5MSA3Ni4xNTY0NTc5LDUzLjE2MTgwMjcgNzUuNzgwMjk5LDUzLjM3MjgwNzIgQzc1LjQxNDczNiw1My41OTIyMSA3NC42MDczMTg4LDUzLjcwMzQ4NiA3My4zNTkxMDY5LDUzLjcwMzQ4NiBMNzIuNzkzMjc5MSw1My43MDM0ODYgTDcyLjQ3NTM5ODMsNTIuNzU3NjM5OCBDNzMuMDE2ODU1Myw1Mi43Nzg2MzUzIDczLjQxNzM4NTEsNTIuNzg4MDgzMyA3My42NzY5ODc3LDUyLjc4ODA4MzMgQzc0LjM4Mzc0MjcsNTIuNzg4MDgzMyA3NC44NDg5MDgyLDUyLjY4OTQwNDUgNzUuMDcyNDg0NCw1Mi40ODk5NDc1IEM3NS4yNjEwOTM3LDUyLjI5MDQ5MDUgNzUuMzkxNDI0OCw1MS45NDkzMTQgNzUuNDYyNDE4Miw1MS40NjY0MTgxIEM3NS40OTczODUxLDUwLjk2MTQ3NjkgNzUuNTUwMzY1Miw0OS40MTIwMTA5IDc1LjYyMDI5OSw0Ni44MTY5NzAxIEw2OS4xNTM1NDQsNDYuODE2OTcwMSBDNjguNTQxMDkzNyw0Ny4zOTUzOTU1IDY3Ljg2NDAwNzYsNDcuODk5Mjg2OSA2Ny4xMjEyMjYxLDQ4LjMyOTY5NDEgTDY2LjUwMjQxODIsNDcuNDMyMTM3NiBDNjcuODMzMjc5MSw0Ni43NTkyMzI2IDY4LjgyOTMwNTYsNDUuODkzMTY5MiA2OS40ODk0MzgsNDQuODMxODQ4IEw2OC4xNDU4NjE5LDQ0LjgzMTg0OCBMNjguMTQ1ODYxOSwzOS43OTA4MzQ0IFogTTYzLjA5MjYxNjgsNTAuMDE1NjMwOCBMNjUuMzAwODI4OCw1MC4wMTU2MzA4IEw2NS4zMDA4Mjg4LDQxLjYzNDIzNzEgTDYzLjA5MjYxNjgsNDEuNjM0MjM3MSBMNjMuMDkyNjE2OCw1MC4wMTU2MzA4IFogTTY2LjQ2NzQ1MTMsNDAuNTkyODYxNSBMNjYuNDY3NDUxMyw1MS44NzQ3ODAxIEw2NS4zMDA4Mjg4LDUxLjg3NDc4MDEgTDY1LjMwMDgyODgsNTEuMDU1OTU2NiBMNjMuMDkyNjE2OCw1MS4wNTU5NTY2IEw2My4wOTI2MTY4LDUyLjIwNjUwODYgTDYxLjg4OTk2NzgsNTIuMjA2NTA4NiBMNjEuODg5OTY3OCw0MC41OTI4NjE1IEw2Ni40Njc0NTEzLDQwLjU5Mjg2MTUgWiIgaWQ9IkZpbGwtOSIgc3Ryb2tlPSIjRkY4ODAwIiBzdHJva2Utd2lkdGg9IjAuMiI+PC9wYXRoPgogICAgICAgICAgICAgICAgPHBhdGggZD0iTTg4LjUyMzcwMSw0MS4yODczOTE5IEw5Ni43OTM4OTk3LDQxLjI4NzM5MTkgTDk2Ljc5Mzg5OTcsNDAuMTk5ODI2MiBMODguNTIzNzAxLDQwLjE5OTgyNjIgTDg4LjUyMzcwMSw0MS4yODczOTE5IFogTTkwLjIyMDEyNDksNDUuNzQ1NzgxIEw4Ny45MDQ4OTMxLDQ1Ljc0NTc4MSBMODcuOTA0ODkzMSw0NC42Mjc3NzE5IEw5Ny4zNTg2Njc5LDQ0LjYyNzc3MTkgTDk3LjM1ODY2NzksNDUuNzQ1NzgxIEw5NC44MzE1MTU2LDQ1Ljc0NTc4MSBMOTQuODMxNTE1Niw1MS43NjQxMzM5IEM5NC44MzE1MTU2LDUyLjIxNjU4NjQgOTUuMDM4MTM4MSw1Mi40NDIyODc4IDk1LjQ1MDMyMzYsNTIuNDQyMjg3OCBMOTUuOTQ1MTU4LDUyLjQ0MjI4NzggQzk2LjE1NzA3ODUsNTIuNDQyMjg3OCA5Ni4zMTYwMTg5LDUyLjM3OTMwMTQgOTYuNDIxOTc5Miw1Mi4yNTMzMjg1IEM5Ni42MTA1ODg1LDUyLjA4NjQxNDUgOTYuNzI4MjA0NCw1MS4zMjk1Mjc2IDk2Ljc3NTg4NjUsNDkuOTg0NzY3NCBMOTcuOTU5NDYyNiw1MC4zNDY5Mzk0IEM5Ny44MjkxMzE1LDUxLjg4MTcwODYgOTcuNjUzMjM3NSw1Mi43ODg3MTMxIDk3LjQyODYwMTcsNTMuMDcyMTUyIEM5Ny4xODE3MTQzLDUzLjM0NjE0MyA5Ni43NzU4ODY1LDUzLjQ4MjYxMzYgOTYuMjEwMDU4Nyw1My40ODI2MTM2IEw5NS4wNDM0MzYxLDUzLjQ4MjYxMzYgQzk0LjU0ODYwMTcsNTMuNDgyNjEzNiA5NC4xNzc3NDA4LDUzLjM0NjE0MyA5My45MzA4NTM0LDUzLjA3MjE1MiBDOTMuNjcxMjUwNyw1Mi44MDAyNjA2IDkzLjU0MTk3OTIsNTIuNDQ3NTM2NyA5My41NDE5NzkyLDUyLjAxNzEyOTQgTDkzLjU0MTk3OTIsNDUuNzQ1NzgxIEw5MS40Mzg2Njc5LDQ1Ljc0NTc4MSBMOTEuNDM4NjY3OSw0Ni44NDkwOTMyIEM5MS4zNzkzMzAyLDQ5LjkzNzUyNzYgODkuODQ4MjA0NCw1Mi4yMDA4Mzk4IDg2Ljg0NDIzMDgsNTMuNjQwMDc5NiBMODUuODkwNTg4NSw1Mi44OTg5Mzk0IEM4OC43MjkyNjQsNTEuNjM4MTYxMSA5MC4xNzI0NDI4LDQ5LjYyMTU0NTcgOTAuMjIwMTI0OSw0Ni44NDkwOTMyIEw5MC4yMjAxMjQ5LDQ1Ljc0NTc4MSBaIE04NC4xNDExODQ1LDQxLjUwNzg0NDMgTDgxLjkxMzg5OTcsNDEuNTA3ODQ0MyBMODEuOTEzODk5Nyw0MC40NTI4MjE3IEw4Ny42NTY5NDYxLDQwLjQ1MjgyMTcgTDg3LjY1Njk0NjEsNDEuNTA3ODQ0MyBMODUuNDMwNzIwOSw0MS41MDc4NDQzIEw4NS40MzA3MjA5LDQ1LjA1MjkzMDMgTDg3LjI4NjA4NTEsNDUuMDUyOTMwMyBMODcuMjg2MDg1MSw0Ni4wNzc1MDk1IEw4NS40MzA3MjA5LDQ2LjA3NzUwOTUgTDg1LjQzMDcyMDksNDkuNjU0MDg4NyBDODYuMDU0ODI2OSw0OS40NDQxMzM5IDg2LjgyMDkxOTYsNDkuMTY1OTQzOSA4Ny43Mjc5Mzk1LDQ4LjgxOTUxODYgTDg3LjcyNzkzOTUsNDkuOTY5MDIwOCBDODYuMDU0ODI2OSw1MC42NTI0MjM1IDg0LjE4NzgwNyw1MS4yNzE3OSA4Mi4xMjY4Nzk4LDUxLjgyODE3MDEgTDgxLjc1NDk1OTMsNTAuNjc3NjE4MSBDODIuNzMyOTcyNiw1MC40MzYxNzAxIDgzLjUyNzY3NDYsNTAuMjI1MTY1NiA4NC4xNDExODQ1LDUwLjA0Nzc1MzggTDg0LjE0MTE4NDUsNDYuMDc3NTA5NSBMODIuMTYxODQ2Nyw0Ni4wNzc1MDk1IEw4Mi4xNjE4NDY3LDQ1LjA1MjkzMDMgTDg0LjE0MTE4NDUsNDUuMDUyOTMwMyBMODQuMTQxMTg0NSw0MS41MDc4NDQzIFoiIGlkPSJGaWxsLTExIiBzdHJva2U9IiNGRjg4MDAiIHN0cm9rZS13aWR0aD0iMC4yIj48L3BhdGg+CiAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMTE1LjQyMDIxNiw0Ni4yMzQ2NjA2IEwxMTcuMTM0NjUzLDQ1Ljg4ODIzNTMgQzExNy4wNDAzNDgsNDUuNTUyMzA3NyAxMTYuODg2NzA2LDQ1LjA2ODM2MiAxMTYuNjc0Nzg1LDQ0LjQzODQ5NzcgQzExNi4yODU5MTEsNDUuMDg5MzU3NSAxMTUuODY3MzY4LDQ1LjY4NzcyODUgMTE1LjQyMDIxNiw0Ni4yMzQ2NjA2IEwxMTUuNDIwMjE2LDQ2LjIzNDY2MDYgWiBNMTE3LjQ4NzUsNDQuMDI4MDM2MiBDMTE3Ljg3NjM3NSw0NS4wMzY4Njg4IDExOC4yMzAyODIsNDYuMjAzMTY3NCAxMTguNTQ4MTYzLDQ3LjUyNTg4MjQgTDExNy42Mjg0MjgsNDcuNzMxNjM4IEwxMTcuMzYzNTI3LDQ2LjY1OTgxOSBDMTE2LjQ5MjUzNCw0Ni44ODAyNzE1IDExNS4zNzM1OTMsNDcuMTIyNzY5MiAxMTQuMDA2NzA2LDQ3LjM4NTIxMjcgTDExMy43NzY3NzIsNDYuNjU5ODE5IEMxMTQuNTY2MTc2LDQ1Ljg5MzQ4NDIgMTE1LjI5NjI0Miw0NC44OTA5NTAyIDExNS45NjgwMyw0My42NTAxMTc2IEMxMTUuMTkwMjgyLDQzLjgxOTEzMTIgMTE0LjUwNjgzOCw0My45NTU2MDE4IDExMy45MTg3NTksNDQuMDYwNTc5MiBMMTEzLjcyMzc5Miw0My4yMzk2NTYxIEMxMTQuMDUzMzI4LDQzLjA2MzI5NDEgMTE0LjYyNTUxNCw0MS44NDM0NTcgMTE1LjQzODIyOSwzOS41ODUzOTM3IEwxMTYuNDYyODY1LDM5LjkxNjA3MjQgQzExNS45MjE0MDgsNDEuMjgxODI4MSAxMTUuNDU1MTgzLDQyLjMwNjQwNzIgMTE1LjA2NzM2OCw0Mi45ODg3NjAyIEwxMTYuNDc5ODE4LDQyLjY1ODA4MTQgQzExNi43ODcxMDMsNDEuOTY1MjMwOCAxMTcuMDIyMzM1LDQxLjM5ODM1MjkgMTE3LjE4NzYzMyw0MC45NTYzOTgyIEwxMTguMTc3MzAyLDQxLjIyNDA5MDUgQzExNy43NjQwNTcsNDIuMzI3NDAyNyAxMTcuMzA1MjQ5LDQzLjMyOTkzNjcgMTE2Ljc5ODc1OSw0NC4yMzM3OTE5IEwxMTcuNDg3NSw0NC4wMjgwMzYyIFogTTEwOS44MzYxMSw0Ni4wOTE4OTE0IEwxMTIuMTUxMzQyLDQ2LjA5MTg5MTQgTDExMi4xNTEzNDIsNDQuNDA3MDA0NSBMMTA5LjgzNjExLDQ0LjQwNzAwNDUgTDEwOS44MzYxMSw0Ni4wOTE4OTE0IFogTTEwOS44MzYxMSw0My40OTI2NTE2IEwxMTIuMTUxMzQyLDQzLjQ5MjY1MTYgTDExMi4xNTEzNDIsNDEuODIyNDYxNSBMMTA5LjgzNjExLDQxLjgyMjQ2MTUgTDEwOS44MzYxMSw0My40OTI2NTE2IFogTTEwNy41MDM5MjQsNDQuMTM5MzEyMiBDMTA3LjkyNzc2NSw0NS4yMDA2MzM1IDEwOC4yOTIyNjksNDYuMzYwNjMzNSAxMDguNTk5NTUzLDQ3LjYyMTQxMTggTDEwNy42ODA4NzgsNDcuODI3MTY3NCBMMTA3LjM2Mjk5Nyw0Ni42NTk4MTkgQzEwNi4yNTQ2NTMsNDYuOTAxMjY3IDEwNS4wNTMwNjMsNDcuMTMyMjE3MiAxMDMuNzU3MTY5LDQ3LjM1MjY2OTcgTDEwMy41MjcyMzYsNDYuNjI4MzI1OCBDMTA0LjM4NzYzMyw0NS44MTg5NTAyIDEwNS4xNjUzODEsNDQuODA1OTE4NiAxMDUuODYwNDgxLDQzLjU4ODE4MSBDMTA1LjAwMDA4Myw0My43NjU1OTI4IDEwNC4yMDUzODEsNDMuOTE3ODEgMTAzLjQ3NTMxNSw0NC4wNDM3ODI4IEwxMDMuMjgwMzQ4LDQzLjIyNjAwOSBDMTAzLjY2OTIyMiw0My4wNTY5OTU1IDEwNC4zNzU5NzcsNDEuODM0MDA5IDEwNS40MDA2MTMsMzkuNTU0OTUwMiBMMTA2LjQyNjMwOCwzOS44ODQ1NzkyIEMxMDUuNzU0NTIsNDEuMjkyMzI1OCAxMDUuMTk1MDUsNDIuMzE2OTA1IDEwNC43NDY4MzgsNDIuOTU3MjY3IEMxMDUuMzQ3NjMzLDQyLjgzMTI5NDEgMTA1Ljg5NTQ0Nyw0Mi43MDUzMjEzIDEwNi4zOTAyODIsNDIuNTc5MzQ4NCBDMTA2LjQ3MjkzMSw0Mi40MTEzODQ2IDEwNi43MTQ1Miw0MS44NjU1MDIzIDEwNy4xMTUwNSw0MC45NDA2NTE2IEwxMDguMDg2NzA2LDQxLjE5MTU0NzUgQzEwNy4yMzkwMjQsNDMuMzAzNjkyMyAxMDYuMjU0NjUzLDQ0Ljk4NDM4MDEgMTA1LjEzNTcxMiw0Ni4yMzQ2NjA2IEMxMDYuMDA3NzY1LDQ2LjA2NjY5NjggMTA2LjY2MTU0LDQ1LjkzNTQ3NTEgMTA3LjA5ODA5Niw0NS44NDA5OTU1IEMxMDYuOTkxMDc3LDQ1LjUxNDUxNTggMTA2LjgyMDQ4MSw0NS4wMzY4Njg4IDEwNi41ODUyNDksNDQuNDA3MDA0NSBMMTA3LjUwMzkyNCw0NC4xMzkzMTIyIFogTTEwOC42NTI1MzQsNDAuOTA5MTU4NCBMMTA5Ljk5NTA1LDQwLjkwOTE1ODQgQzExMC4yNDI5OTcsNDAuMzg0MjcxNSAxMTAuNDM2OTA0LDM5Ljg0MjU4ODIgMTEwLjU3ODg5MSwzOS4yODYyMDgxIEwxMTEuNzYyNDY3LDM5LjQyODk3NzQgQzExMS42MzIxMzYsMzkuODg5ODI4MSAxMTEuNDMyOTMxLDQwLjM4NDI3MTUgMTExLjE2MTY3Myw0MC45MDkxNTg0IEwxMTMuMzE3OTY0LDQwLjkwOTE1ODQgTDExMy4zMTc5NjQsNDcuMDA2MjQ0MyBMMTExLjYwMzUyNyw0Ny4wMDYyNDQzIEwxMTEuNjAzNTI3LDQ4LjM5Mjk5NTUgTDExOC42MDExNDMsNDguMzkyOTk1NSBMMTE4LjYwMTE0Myw0OS40NTAxMTc2IEwxMTIuOTExMDc3LDQ5LjQ1MDExNzYgQzExNC4yMzAyODIsNTAuNzUxODM3MSAxMTYuMjg1OTExLDUxLjc4MDYxNTQgMTE5LjA3Nzk2NCw1Mi41Mzc1MDIzIEwxMTguNDk1MTgzLDUzLjY0MDgxNDUgQzExNS4zNTAyODIsNTIuNTY4OTk1NSAxMTMuMTE2NjQsNTEuMTcxNzQ2NiAxMTEuNzk4NDk0LDQ5LjQ1MDExNzYgTDExMS42MDM1MjcsNDkuNDUwMTE3NiBMMTExLjYwMzUyNyw1My43MDI3NTExIEwxMTAuMzMwOTQ0LDUzLjcwMjc1MTEgTDExMC4zMzA5NDQsNDkuNDUwMTE3NiBMMTEwLjEzNzAzNyw0OS40NTAxMTc2IEMxMDkuMDA1MzgxLDUxLjA0NTc3MzggMTA2LjgyNjgzOCw1Mi40MzE0NzUxIDEwMy41OTgyMjksNTMuNjA4MjcxNSBMMTAyLjg3NDUyLDUyLjU1MzI0ODkgQzEwNS44ODkwOSw1MS42Mzc4NDYyIDEwNy45NDU3NzksNTAuNjA0ODY4OCAxMDkuMDQxNDA4LDQ5LjQ1MDExNzYgTDEwMy4zMTYzNzUsNDkuNDUwMTE3NiBMMTAzLjMxNjM3NSw0OC4zOTI5OTU1IEwxMTAuMzMwOTQ0LDQ4LjM5Mjk5NTUgTDExMC4zMzA5NDQsNDcuMDA2MjQ0MyBMMTA4LjY1MjUzNCw0Ny4wMDYyNDQzIEwxMDguNjUyNTM0LDQwLjkwOTE1ODQgWiIgaWQ9IkZpbGwtMTMiIHN0cm9rZT0iI0ZGODgwMCIgc3Ryb2tlLXdpZHRoPSIwLjIiPjwvcGF0aD4KICAgICAgICAgICAgICAgIDxwYXRoIGQ9Ik0xMzguMDQxMjM0LDQyLjQ5OTg4MDUgQzEzNy41MjMwODgsNDMuNzA4MTcwMSAxMzYuODIyNjkxLDQ0LjkyODAwNzIgMTM1LjkzODk4Miw0Ni4xNTUxOTI4IEwxMzQuODA3MzI2LDQ1LjYzNTU1NDggQzEzNS42NzkzNzksNDQuMzg1Mjc0MiAxMzYuMzY4MTIxLDQzLjE3ODAzNDQgMTM2Ljg3NDYxMSw0Mi4wMTE3MzU3IEwxMzguMDQxMjM0LDQyLjQ5OTg4MDUgWiBNMTI2Ljg1NjA2OCw0Mi4wOTA0Njg4IEMxMjcuNTM4NDUyLDQzLjIxNTgyNjIgMTI4LjE3NTI3Myw0NC40MTY3Njc0IDEyOC43NjQ0MTIsNDUuNjk4NTQxMiBMMTI3LjU3OTc3Nyw0Ni4yMTgxNzkyIEMxMjYuOTkwNjM4LDQ0Ljg4MzkxNjcgMTI2LjM1NDg3Niw0My42ODE5MjU4IDEyNS42NzE0MzIsNDIuNjEwMTA2OCBMMTI2Ljg1NjA2OCw0Mi4wOTA0Njg4IFogTTEyNC42OTk3NzcsMzkuOTgwNDIzNSBMMTM4Ljk3NzkyMiwzOS45ODA0MjM1IEwxMzguOTc3OTIyLDQxLjA4MTYzNjIgTDEzMi40MDQxNDgsNDEuMDgxNjM2MiBMMTMyLjQwNDE0OCw0Ny4wMzgwNTI1IEwxMzkuNjQ5NzExLDQ3LjAzODA1MjUgTDEzOS42NDk3MTEsNDguMTI0NTY4MyBMMTMyLjQwNDE0OCw0OC4xMjQ1NjgzIEwxMzIuNDA0MTQ4LDUzLjcwMzA2NjEgTDEzMS4wOTY1OTgsNTMuNzAzMDY2MSBMMTMxLjA5NjU5OCw0OC4xMjQ1NjgzIEwxMjMuOTkzMDIyLDQ4LjEyNDU2ODMgTDEyMy45OTMwMjIsNDcuMDM4MDUyNSBMMTMxLjA5NjU5OCw0Ny4wMzgwNTI1IEwxMzEuMDk2NTk4LDQxLjA4MTYzNjIgTDEyNC42OTk3NzcsNDEuMDgxNjM2MiBMMTI0LjY5OTc3NywzOS45ODA0MjM1IFoiIGlkPSJGaWxsLTE1IiBzdHJva2U9IiNGRjg4MDAiIHN0cm9rZS13aWR0aD0iMC4yIj48L3BhdGg+CiAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMTQ3LjM1NjgyMSw1MS44NTk2NjMzIEwxNTYuNTgwNjYyLDUxLjg1OTY2MzMgTDE1Ni41ODA2NjIsNDguMjUwNTQxMiBMMTQ3LjM1NjgyMSw0OC4yNTA1NDEyIEwxNDcuMzU2ODIxLDUxLjg1OTY2MzMgWiBNMTU3Ljg3MDE5OSw0Ny4xNjI5NzU2IEwxNTcuODcwMTk5LDUzLjczNDU1OTMgTDE1Ni41ODA2NjIsNTMuNzM0NTU5MyBMMTU2LjU4MDY2Miw1Mi45NDYxNzkyIEwxNDcuMzU2ODIxLDUyLjk0NjE3OTIgTDE0Ny4zNTY4MjEsNTMuNzM0NTU5MyBMMTQ2LjA2NzI4NSw1My43MzQ1NTkzIEwxNDYuMDY3Mjg1LDQ3LjE2Mjk3NTYgTDE1Ny44NzAxOTksNDcuMTYyOTc1NiBaIE0xNDQuNTY0NzY4LDQ0LjQ2OTI1NjEgQzE0Ni4xMTkyMDUsNDMuOTk2ODU3OSAxNDguMDQ1NTYzLDQyLjI1NDIzMzUgMTUwLjM0Mjc4MSwzOS4yMzkyODMzIEwxNTEuNjUwMzMxLDM5LjYzMjk0ODQgQzE1MC4wNTk4NjgsNDEuNjQ5NTYzOCAxNDguNDY0MTA2LDQzLjI0NjI2OTcgMTQ2Ljg2MTk4Nyw0NC40MjMwNjYxIEMxNTAuMDMwMTk5LDQ0LjMwNzU5MSAxNTMuMjQ2MDkzLDQ0LjExMzM4MjggMTU2LjUxMDcyOCw0My44MzkzOTE5IEMxNTUuNzkxMjU4LDQyLjkzNjU4NjQgMTU1LjEwMTQ1Nyw0Mi4xNDI5NTc1IDE1NC40NDIzODQsNDEuNDYwNjA0NSBMMTU1LjU5MDk5Myw0MC45NzI0NTk3IEMxNTcuMDk4ODA4LDQyLjUzNzY3MjQgMTU4LjUxMjMxOCw0NC4yODAyOTY4IDE1OS44MzI1ODMsNDYuMjAyNDMyNiBMMTU4LjU5NDk2Nyw0Ni43Mzg4NjcgQzE1OC4zNzEzOTEsNDYuNDAyOTM5NCAxNTcuOTM0ODM0LDQ1Ljc3NzI3NDIgMTU3LjI4NzQxNyw0NC44NjM5NzEgQzE1My42NzA5OTMsNDUuMTU3OTA3NyAxNDkuNTEzMTEzLDQ1LjM4MzYwOSAxNDQuODExNjU2LDQ1LjU0MTA3NTEgTDE0NC41NjQ3NjgsNDQuNDY5MjU2MSBaIiBpZD0iRmlsbC0xNiIgc3Ryb2tlPSIjRkY4ODAwIiBzdHJva2Utd2lkdGg9IjAuMiI+PC9wYXRoPgogICAgICAgICAgICAgICAgPHBhdGggZD0iTTAuOTc1Nzg4MDc5LDE0LjY2OTY0MzQgTDAuOTc1Nzg4MDc5LDE0LjU4ODgxMDkgQzAuOTc1Nzg4MDc5LDYuNTY5NTg5MTQgNy40OTEyODQ3NywwLjAwMDEwNDk3NzM3NiAxNi40MDM2MDI2LDAuMDAwMTA0OTc3Mzc2IEMyMC44NTkyMzE4LDAuMDAwMTA0OTc3Mzc2IDIzLjgwMTc0ODMsMC45NjY5NDY2MDYgMjYuNDUwNzU1LDIuNzQxMDY0MjUgQzI3LjA4MTIxODUsMy4xODQwNjg3OCAyNy43OTY0NTAzLDQuMDMwMTg2NDMgMjcuNzk2NDUwMyw1LjIzOTUyNTc5IEMyNy43OTY0NTAzLDYuOTMxNzYxMDkgMjYuMzY1OTg2OCw4LjMwMjc2NTYxIDI0LjYwMDY4ODcsOC4zMDI3NjU2MSBDMjMuNjc1NjU1Niw4LjMwMjc2NTYxIDIzLjA4NzU3NjIsNy45Nzk0MzUyOSAyMi42MjU1ODk0LDcuNjU3MTU0NzUgQzIwLjg1OTIzMTgsNi40NDg4NjUxNiAxOC45Njc4NDExLDUuNzIzNDcxNDkgMTYuMTkzODAxMyw1LjcyMzQ3MTQ5IEMxMS40ODQ5MjcyLDUuNzIzNDcxNDkgNy43NDM0NzAyLDkuNzEyNjExNzYgNy43NDM0NzAyLDE0LjUwOTAyODEgTDcuNzQzNDcwMiwxNC41ODg4MTA5IEM3Ljc0MzQ3MDIsMTkuNzQ3Mzk5MSAxMS40NDI1NDMsMjMuNTM2MDMyNiAxNi42NTU3ODgxLDIzLjUzNjAzMjYgQzE5LjAxMDIyNTIsMjMuNTM2MDMyNiAyMS4xMTE0MTcyLDIyLjk3MjMwNDEgMjIuNzUxNjgyMSwyMS44NDM3OTczIEwyMi43NTE2ODIxLDE3LjgxMjY2NjEgTDE4LjM3OTc2MTYsMTcuODEyNjY2MSBDMTYuODI0MjY0OSwxNy44MTI2NjYxIDE1LjU2MzMzNzcsMTYuNjQ0MjY3OSAxNS41NjMzMzc3LDE1LjE1MzU4OTEgQzE1LjU2MzMzNzcsMTMuNjYxODYwNiAxNi44MjQyNjQ5LDEyLjQ1MzU3MSAxOC4zNzk3NjE2LDEyLjQ1MzU3MSBMMjUuNzc3OTA3MywxMi40NTM1NzEgQzI3LjU4NTU4OTQsMTIuNDUzNTcxIDI5LjAxNDk5MzQsMTMuODIyNDc2IDI5LjAxNDk5MzQsMTUuNTU2NzAyMyBMMjkuMDE0OTkzNCwyMi40MDc1MjU4IEMyOS4wMTQ5OTM0LDI0LjIyMTUzNDggMjguMzAwODIxMiwyNS40NzA3NjU2IDI2Ljc0NTMyNDUsMjYuMzU3ODI0NCBDMjQuMzQ4NTAzMywyNy43Njg3MjA0IDIwLjg1OTIzMTgsMjkuMTc4NTY2NSAxNi40NDU5ODY4LDI5LjE3ODU2NjUgQzcuMjgxNDgzNDQsMjkuMTc4NTY2NSAwLjk3NTc4ODA3OSwyMy4wMTIxOTU1IDAuOTc1Nzg4MDc5LDE0LjY2OTY0MzQiIGlkPSJGaWxsLTE3Ij48L3BhdGg+CiAgICAgICAgICAgICAgICA8cGF0aCBkPSJNNTYuMzM4OTY2OSwxNC42Njk2NDM0IEw1Ni4zMzg5NjY5LDE0LjU4ODgxMDkgQzU2LjMzODk2NjksOS43NTI1MDMxNyA1Mi42Mzk4OTQsNS43MjM0NzE0OSA0Ny40MjY2NDksNS43MjM0NzE0OSBDNDIuMjE0NDYzNiw1LjcyMzQ3MTQ5IDM4LjU5OTA5OTMsOS42NzE2NzA1OSAzOC41OTkwOTkzLDE0LjUwOTAyODEgTDM4LjU5OTA5OTMsMTQuNTg4ODEwOSBDMzguNTk5MDk5MywxOS40MjUxMTg2IDQyLjI5OTIzMTgsMjMuNDU1MiA0Ny41MTAzNTc2LDIzLjQ1NTIgQzUyLjcyMzYwMjYsMjMuNDU1MiA1Ni4zMzg5NjY5LDE5LjUwNTk1MTEgNTYuMzM4OTY2OSwxNC42Njk2NDM0IE0zMS44MzE0MTcyLDE0LjY2OTY0MzQgTDMxLjgzMTQxNzIsMTQuNTg4ODEwOSBDMzEuODMxNDE3Miw2LjU2OTU4OTE0IDM4LjQzMDYyMjUsMC4wMDAxMDQ5NzczNzYgNDcuNTEwMzU3NiwwLjAwMDEwNDk3NzM3NiBDNTYuNTkxMTUyMywwLjAwMDEwNDk3NzM3NiA2My4xMDY2NDksNi40ODg3NTY1NiA2My4xMDY2NDksMTQuNTA5MDI4MSBMNjMuMTA2NjQ5LDE0LjU4ODgxMDkgQzYzLjEwNjY0OSwyMi42MDkwODI0IDU2LjUwNzQ0MzcsMjkuMTc4NTY2NSA0Ny40MjY2NDksMjkuMTc4NTY2NSBDMzguMzQ2OTEzOSwyOS4xNzg1NjY1IDMxLjgzMTQxNzIsMjIuNjg5OTE0OSAzMS44MzE0MTcyLDE0LjY2OTY0MzQiIGlkPSJGaWxsLTE4Ij48L3BhdGg+CiAgICAgICAgICAgICAgICA8cGF0aCBkPSJNNjYuNzY0ODIxMiwzLjQyNTYyMTcyIEM2Ni43NjQ4MjEyLDEuNjkzNDk1MDIgNjguMTk0MjI1MiwwLjMyMjQ5MDQ5OCA3MC4wMDE5MDczLDAuMzIyNDkwNDk4IEw3MC43MTcxMzkxLDAuMzIyNDkwNDk4IEM3Mi4xMDQxNTg5LDAuMzIyNDkwNDk4IDczLjA3MDUxNjYsMS4wMDY5NDI5OSA3My42NTg1OTYsMS45MzQ5NDI5OSBMODEuNDc4NDYzNiwxNC4xNDU5MTEzIEw4OS4zMzg1OTYsMS44OTQwMDE4MSBDOTAuMDExNDQzNywwLjg0NjMyNzYwMiA5MC45MzY0NzY4LDAuMzIyNDkwNDk4IDkyLjIzOTc4ODEsMC4zMjI0OTA0OTggTDkyLjk1Mzk2MDMsMC4zMjI0OTA0OTggQzk0Ljc2MTY0MjQsMC4zMjI0OTA0OTggOTYuMTkxMDQ2NCwxLjY5MzQ5NTAyIDk2LjE5MTA0NjQsMy40MjU2MjE3MiBMOTYuMTkxMDQ2NCwyNS44MzQwOTIzIEM5Ni4xOTEwNDY0LDI3LjU2NjIxOSA5NC43NjE2NDI0LDI4LjkzNzIyMzUgOTIuOTUzOTYwMywyOC45MzcyMjM1IEM5MS4xODg2NjIzLDI4LjkzNzIyMzUgODkuNzU5MjU4MywyNy41MjYzMjc2IDg5Ljc1OTI1ODMsMjUuODM0MDkyMyBMODkuNzU5MjU4MywxMS43NjgxNzM4IEw4NC4wODQwMjY1LDIwLjE1MTY2NyBDODMuNDExMTc4OCwyMS4xMTg1MDg2IDgyLjU3MDkxMzksMjEuNzIzMTc4MyA4MS4zOTM2OTU0LDIxLjcyMzE3ODMgQzgwLjIxNjQ3NjgsMjEuNzIzMTc4MyA3OS4zNzYyMTE5LDIxLjExODUwODYgNzguNzAzMzY0MiwyMC4xNTE2NjcgTDczLjExMjkwMDcsMTEuODg5OTQ3NSBMNzMuMTEyOTAwNywyNS45MTM4NzUxIEM3My4xMTI5MDA3LDI3LjYwNjExMDQgNzEuNjgzNDk2NywyOC45MzcyMjM1IDY5LjkxODE5ODcsMjguOTM3MjIzNSBDNjguMTUxODQxMSwyOC45MzcyMjM1IDY2Ljc2NDgyMTIsMjcuNjA2MTEwNCA2Ni43NjQ4MjEyLDI1LjkxMzg3NTEgTDY2Ljc2NDgyMTIsMy40MjU2MjE3MiBaIiBpZD0iRmlsbC0xOSI+PC9wYXRoPgogICAgICAgICAgICAgICAgPHBhdGggZD0iTTExNy43MTM2OTUsMTYuODg2MDMwOCBMMTEzLjYzNjM0NCw3LjU3NjYzNzEgTDEwOS41NTg5OTMsMTYuODg2MDMwOCBMMTE3LjcxMzY5NSwxNi44ODYwMzA4IFogTTk5LjUxMTg0MTEsMjQuNzA0NzQ1NyBMMTA5Ljc2ODc5NSwyLjQ5ODg4MTQ1IEMxMTAuNDg0MDI2LDAuOTY3MjYxNTM4IDExMS43ODYyNzgsMC4wNDAzMTEzMTIyIDExMy41NTI2MzYsMC4wNDAzMTEzMTIyIEwxMTMuOTMwOTE0LDAuMDQwMzExMzEyMiBDMTE1LjY5NjIxMiwwLjA0MDMxMTMxMjIgMTE2Ljk1NzEzOSwwLjk2NzI2MTUzOCAxMTcuNjcxMzExLDIuNDk4ODgxNDUgTDEyNy45MjkzMjUsMjQuNzA0NzQ1NyBDMTI4LjEzOTEyNiwyNS4xNDc3NTAyIDEyOC4yNjUyMTksMjUuNTUwODYzMyAxMjguMjY1MjE5LDI1Ljk1NTAyNjIgQzEyOC4yNjUyMTksMjcuNjA2MzIwNCAxMjYuOTE5NTIzLDI4LjkzNjM4MzcgMTI1LjE5NjYwOSwyOC45MzYzODM3IEMxMjMuNjgzNDk3LDI4LjkzNjM4MzcgMTIyLjY3NDc1NSwyOC4wOTEzMTU4IDEyMi4wODU2MTYsMjYuODAxMTQzOSBMMTIwLjExMDUxNywyMi4zNjc5NDkzIEwxMDcuMTYyMTcyLDIyLjM2Nzk0OTMgTDEwNS4xMDMzNjQsMjcuMDAyNzAwNSBDMTA0LjU1NjYwOSwyOC4yMTA5OSAxMDMuNDYzMDk5LDI4LjkzNjM4MzcgMTAyLjExODQ2NCwyOC45MzYzODM3IEMxMDAuNDM2ODc0LDI4LjkzNjM4MzcgOTkuMTMzNTYyOSwyNy42NDcyNjE1IDk5LjEzMzU2MjksMjYuMDM1ODU4OCBDOTkuMTMzNTYyOSwyNS41OTE4MDQ1IDk5LjMwMjAzOTcsMjUuMTQ3NzUwMiA5OS41MTE4NDExLDI0LjcwNDc0NTcgTDk5LjUxMTg0MTEsMjQuNzA0NzQ1NyBaIiBpZD0iRmlsbC0yMCI+PC9wYXRoPgogICAgICAgICAgICAgICAgPHBhdGggZD0iTTEzMC4xNTY3MTUsMjYuNjM5NDc4NyBDMTI5LjQ4Mzg2OCwyNi4xNTY1ODI4IDEyOC45MzgxNzIsMjUuMjI4NTgyOCAxMjguOTM4MTcyLDI0LjI2MDY5MTQgQzEyOC45MzgxNzIsMjIuNjA5Mzk3MyAxMzAuMjgyODA4LDIxLjI4MDM4MzcgMTMyLjAwNjc4MSwyMS4yODAzODM3IEMxMzIuODA1NzIyLDIxLjI4MDM4MzcgMTMzLjMxMDA5MywyMS40ODA4OTA1IDEzMy45NDA1NTYsMjEuOTIzODk1IEMxMzUuMjQzODY4LDIyLjg1MTg5NSAxMzYuMzc4NzAyLDIzLjMzNTg0MDcgMTM3Ljg0OTQzLDIzLjMzNTg0MDcgQzE0MC4zNzIzNDQsMjMuMzM1ODQwNyAxNDEuODg1NDU3LDIxLjkyMzg5NSAxNDEuODg1NDU3LDE4LjY1OTA5ODYgTDE0MS44ODU0NTcsMy4zNDQ5OTkxIEMxNDEuODg1NDU3LDEuNjExODIyNjIgMTQzLjMxNDg2MSwwLjI0MTg2Nzg3MyAxNDUuMTIyNTQzLDAuMjQxODY3ODczIEMxNDYuOTMwMjI1LDAuMjQxODY3ODczIDE0OC4zNTk2MjksMS42MTE4MjI2MiAxNDguMzU5NjI5LDMuMzQ0OTk5MSBMMTQ4LjM1OTYyOSwxOC45NDE0ODc4IEMxNDguMzU5NjI5LDIyLjI4NzExNjcgMTQ3LjM1MDg4NywyNC43ODQ1Mjg1IDE0NS41ODQ1MywyNi40Nzg4NjMzIEMxNDMuNzc2ODQ4LDI4LjIxMDk5IDE0MS4xMjg5MDEsMjkuMDk4MDQ4OSAxMzcuOTM0MTk5LDI5LjA5ODA0ODkgQzEzNC41NzEwMiwyOS4wOTgwNDg5IDEzMi4wMDY3ODEsMjguMDA5NDMzNSAxMzAuMTU2NzE1LDI2LjYzOTQ3ODciIGlkPSJGaWxsLTIxIj48L3BhdGg+CiAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMTUzLjE1MTM2NCwzLjM0NDU3OTE5IEMxNTMuMTUxMzY0LDEuNjEyNDUyNDkgMTU0LjU4MDc2OCwwLjI0MTQ0Nzk2NCAxNTYuMzg4NDUsMC4yNDE0NDc5NjQgQzE1OC4xOTYxMzIsMC4yNDE0NDc5NjQgMTU5LjYyNDQ3NywxLjYxMjQ1MjQ5IDE1OS42MjQ0NzcsMy4zNDQ1NzkxOSBMMTU5LjYyNDQ3NywyNS44MzM4ODI0IEMxNTkuNjI0NDc3LDI3LjU2NjAwOSAxNTguMTk2MTMyLDI4LjkzNzAxMzYgMTU2LjM4ODQ1LDI4LjkzNzAxMzYgQzE1NC41ODA3NjgsMjguOTM3MDEzNiAxNTMuMTUxMzY0LDI3LjU2NjAwOSAxNTMuMTUxMzY0LDI1LjgzMzg4MjQgTDE1My4xNTEzNjQsMy4zNDQ1NzkxOSBaIiBpZD0iRmlsbC0yMiI+PC9wYXRoPgogICAgICAgICAgICA8L2c+CiAgICAgICAgPC9nPgogICAgPC9nPgo8L3N2Zz4="
                                        alt="GOMAJI LOGO">
                                </div>
                                <div class="process d-flex">
                                    <div class="symbol move">
                                        <i class="fa fa-chevron-right" aria-hidden="true" style="color: #ffead2;"></i>
                                    </div>
                                    <div class="symbol move">
                                        <i class="fa fa-chevron-right" aria-hidden="true" style="color: #ffce96;"></i>
                                    </div>
                                    <div class="symbol move">
                                        <i class="fa fa-chevron-right" aria-hidden="true" style="color: #ffab4b;"></i>
                                    </div>
                                    <div class="symbol move">
                                        <i class="fa fa-chevron-right t-main" aria-hidden="true"></i>
                                    </div>
                                    <div class="symbol move">
                                        <i class="fa fa-chevron-right t-main" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <div class="thirdparty-logo">
                                    <img src="{{ $logo }}" alt="LOGO">
                                </div>
                            </div>
                            <div class="brand-detail">
                                <h3 class="text-center">您即將完成<span class="t-main">{{ $mainReward }}</span>點數回饋！</h3>
                                <p class="text-center t-darkdanger mt-3 mb-3">{{ $note }}</p>
                                <a class="btn btn-main m-auto w-75 text-center" id="redirect-btn" href="{{ $storeWebsite }}" rel="buy">
                                    讀取太久等不及了？現在就去
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End:main -->
@endsection

@section('script')
    <script>
        let redirectUri = '{{ $storeWebsite }}';
        setTimeout(function() {
            document.getElementById('redirect-btn').click();
        }, 3000);
    </script>
@endsection