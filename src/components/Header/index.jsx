import AppBar from "@mui/material/AppBar"
import Box from "@mui/material/Box"
import Toolbar from "@mui/material/Toolbar"
import Typography from "@mui/material/Typography"
import Button from "@mui/material/Button"
import IconButton from "@mui/material/IconButton"
import MenuIcon from "@mui/icons-material/Menu"
import {Link, NavLink} from "react-router-dom"
import {makeStyles} from "@mui/styles"
import Dialog from "@mui/material/Dialog"
import DialogContent from "@mui/material/DialogContent"
import {useEffect, useState} from "react"

import Register from "../../features/Auth/components/Register"
import listMenuApi from "../../api/apiListMenu"
const useStyle = makeStyles(() => ({
  title: {
    textDecoration: "none",
    color: "#FFF",
    fontWeight: "500",
  },
}))

export default function Head() {
  const classes = useStyle()
  const [listMenu, setListMenu] = useState([])
  const [open, setOpen] = useState(false)
  const handleClickOpen = () => {
    setOpen(true)
  }

  const handleClose = () => {
    setOpen(false)
  }
  useEffect(() => {
    try {
      const getListMenu = async () => {
        const listApi = await listMenuApi.getAll()
        if (listApi.error === 0) {
          setListMenu(listApi.result)
        }
      }
      getListMenu()
    } catch (error) {
      console.error(error)
    }
  }, [])
  return (
    <Box sx={{flexGrow: 1}}>
      <AppBar position='static'>
        <Toolbar>
          <IconButton
            size='large'
            edge='start'
            color='inherit'
            aria-label='menu'
            sx={{mr: 2}}>
            <MenuIcon />
          </IconButton>
          <Box sx={{flexGrow: 1}}>
            {listMenu.map((menu) => (
              <Typography key={menu.id} variant='h6' component='span'>
                <NavLink className={classes.title}>
                  <Button color='inherit'>{menu.title}</Button>
                </NavLink>
              </Typography>
            ))}
          </Box>
          <Typography variant='h6'>
            <Button color='inherit' onClick={handleClickOpen}>
              Register
            </Button>
          </Typography>
        </Toolbar>
      </AppBar>
      <Dialog
        open={open}
        onClose={(event, reason) => {
          if (reason !== "backdropClick" || reason !== "escapeKeyDown") {
            handleClose
          }
        }}>
        <DialogContent>
          <Register handleClose={handleClose} />
        </DialogContent>
      </Dialog>
    </Box>
  )
}
