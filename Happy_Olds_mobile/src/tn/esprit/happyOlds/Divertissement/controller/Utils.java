/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.Divertissement.controller;

import com.codename1.ui.Button;
import com.codename1.ui.plaf.Border;
import com.codename1.ui.plaf.Style;
import com.fasterxml.jackson.databind.DeserializationFeature;
import com.fasterxml.jackson.databind.ObjectMapper;
import java.io.IOException;
import java.util.List;

/**
 *
 * @author touir
 */
public class Utils {
    
    
    public static final String serverUrl = "http://127.0.0.1:8000";
    public static final String apiUrl = serverUrl+"/api";
    
    
    private static ObjectMapper mapper; 
    public static ObjectMapper getMapperInstance(){
        if(mapper != null) return mapper;
        
        mapper = new ObjectMapper();
        mapper.configure(DeserializationFeature.FAIL_ON_UNKNOWN_PROPERTIES, false);
        
        return mapper;
    }
    
    public static <T extends Object> List<T> mapList(String json, Class<T> clazz) throws IOException{
        ObjectMapper mapper = Utils.getMapperInstance();
        
        List<T> result = mapper.readValue(
            json, 
            mapper.getTypeFactory().constructCollectionType(
                List.class, 
                clazz
            )
        );
        
        return result;
    }
    public static <T extends Object> T mapObject(String json, Class<T> clazz) throws IOException{
        ObjectMapper mapper = Utils.getMapperInstance();
        return mapper.readValue(json, clazz);
    }
    
    public static Button getHyperlinkButton(String label){
        Button hyperlinkButton = new Button(label);
        hyperlinkButton.getAllStyles().setBorder(Border.createEmpty());
        hyperlinkButton.getAllStyles().setTextDecoration(Style.TEXT_DECORATION_UNDERLINE);
        hyperlinkButton.getAllStyles().setFgColor(0x0000FF);
        return hyperlinkButton;
    }
}
