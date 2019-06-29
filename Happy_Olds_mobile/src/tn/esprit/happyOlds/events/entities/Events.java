/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.events.entities;

import java.util.Date;
import tn.esprit.happyOlds.entity.User;

/**
 *
 * @author Romdhani
 */
public class Events {
     private int id;
     private String titre;
     private String description;
     private User id_user;
     private int nbrParticipant;
     private Date dateDebut;
     private Date dateFin;
     private String privilege;
     public String path;
     public String ville;
     private String file;
     private int nbrDispo;
     private int participant;

    public Events() {
    }

    public String getVille() {
        return ville;
    }

    public void setVille(String ville) {
        this.ville = ville;
    }

    public int getNbrDispo() {
        return nbrDispo;
    }

    public void setNbrDispo(int nbrDispo) {
        this.nbrDispo = nbrDispo;
    }

    public int getParticipant() {
        return participant;
    }

    public void setParticipant(int participant) {
        this.participant = participant;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getTitre() {
        return titre;
    }

    public void setTitre(String titre) {
        this.titre = titre;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public User getId_user() {
        return id_user;
    }

    public void setId_user(User id_user) {
        this.id_user = id_user;
    }

    public int getNbrParticipant() {
        return nbrParticipant;
    }

    public void setNbrParticipant(int nbrParticipant) {
        this.nbrParticipant = nbrParticipant;
    }

    public Date getDateDebut() {
        return dateDebut;
    }

    public void setDateDebut(Date dateDebut) {
        this.dateDebut = dateDebut;
    }

    public Date getDateFin() {
        return dateFin;
    }

    public void setDateFin(Date dateFin) {
        this.dateFin = dateFin;
    }

    public String getPrivilege() {
        return privilege;
    }

    public void setPrivilege(String privilege) {
        this.privilege = privilege;
    }

    public String getPath() {
        return path;
    }

    public void setPath(String path) {
        this.path = path;
    }

    public String getFile() {
        return file;
    }

    public void setFile(String file) {
        this.file = file;
    }

    @Override
    public String toString() {
        return "Events{" + "id=" + id + ", titre=" + titre + ", description=" + description + ", id_user=" + id_user + ", nbrParticipant=" + nbrParticipant + ", dateDebut=" + dateDebut + ", dateFin=" + dateFin + ", privilege=" + privilege + ", path=" + path + ", file=" + file + '}';
    }
     
    
}
