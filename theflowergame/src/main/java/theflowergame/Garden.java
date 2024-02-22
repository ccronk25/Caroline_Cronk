package theflowergame;

import javax.swing.JPanel;
import java.util.Random;

/**
 * The grid on which the flowers live.
 * @author ccronk
 */

public class Garden {
    
    private Flower[][] flowers;
    private JPanel panel;
    private GameRunner game; //so it can access the JPanel
   
    public static final int ROWS = 50;
    public static final int COLUMNS = 75;

    Random randomNumberGenerator = new Random();
    
    public Garden(GameRunner myGame){
        game = myGame;
    }   
    
    /**
     * Creates and fills a 2D array of flowers within the GUI JPanel.
     */
    public void createGarden(){
        //recieves the panel created in the GUI customizer
        panel = game.getPanel(); 
        flowers = new Flower[ROWS][COLUMNS];
        
        for(int ii = 0; ii < ROWS; ii++){
            for(int jj = 0; jj < COLUMNS; jj++){
                flowers[ii][jj] = new Flower(ii,jj,this,Flower.DEAD);
                panel.add(flowers[ii][jj].getButton());
            }
        }   
    }
    
    /**
     * Goes through the array of flowers and randomly picks some to be alive.
     * Used by the Random Fill button.
     */
    public void randomizeFlowers(){
        //set up comparison for number generator
        double threshold = 0.7; 
        
        //loop through all flowers and set 30% to alive
        for(int ii = 0; ii < ROWS; ii++){
            for(int jj = 0; jj < COLUMNS; jj++){
                double random = randomNumberGenerator.nextDouble();
                if (random > threshold){
                    flowers[ii][jj].setStatus(Flower.ALIVE);
                }
                else{
                    flowers[ii][jj].setStatus(Flower.DEAD);
                }
            }
        }    
    }
    
    //accessor
    public Flower[][] getFlowerGrid(){
        return flowers;
    }
    
}
