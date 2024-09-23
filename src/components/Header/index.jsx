import AppBar from '@mui/material/AppBar';
import Box from '@mui/material/Box';
import Toolbar from '@mui/material/Toolbar';
import Typography from '@mui/material/Typography';
import Button from '@mui/material/Button';
import IconButton from '@mui/material/IconButton';
import MenuIcon from '@mui/icons-material/Menu';
import { Link, NavLink } from 'react-router-dom';
import { makeStyles } from '@mui/styles';
import Dialog from '@mui/material/Dialog';
import DialogActions from '@mui/material/DialogActions';
import DialogContent from '@mui/material/DialogContent';
import DialogContentText from '@mui/material/DialogContentText';
import DialogTitle from '@mui/material/DialogTitle';
import { useState } from 'react';

import Register from '../../features/Auth/components/Register';
const useStyle = makeStyles(() => ({
    title: {
        textDecoration: "none",
        color: "#FFF",
        fontWeight: "500"
    }
}))

export default function Head() {
    const classes = useStyle()
    const [open, setOpen] = useState(false);
    const handleClickOpen = () => {
        setOpen(true);
    };

    const handleClose = () => {
        setOpen(false);
    };
    return (
        <Box sx={{ flexGrow: 1 }}>
            <AppBar position="static">
                <Toolbar>
                    <IconButton
                        size="large"
                        edge="start"
                        color="inherit"
                        aria-label="menu"
                        sx={{ mr: 2 }}
                    >
                        <MenuIcon />
                    </IconButton>
                    <Typography variant='h6'><Link to="/" className={classes.title}><Button color="inherit">Home</Button></Link></Typography>
                    <Box sx={{ flexGrow: 1 }}>
                        <Typography variant="h6" component="span">
                            <NavLink className={classes.title}><Button color="inherit">News</Button></NavLink>
                        </Typography>
                        <Typography variant="h6" component="span">
                            <NavLink className={classes.title}><Button color="inherit">News</Button></NavLink>
                        </Typography>
                    </Box>
                    <Typography variant='h6'>
                        <Button color="inherit" onClick={handleClickOpen}>Register</Button>
                    </Typography>
                </Toolbar>
            </AppBar>
            <Dialog
                open={open}
                onClose={(event, reason) => {
                    if (reason !== "backdropClick" || reason !== "escapeKeyDown") {
                        handleClose
                    }
                }}
            >
                <DialogContent>
                    <Register handleClose={handleClose} />
                </DialogContent>
            </Dialog>
        </Box>
    );
}