package theflowergame;

import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;

/**
 *
 * @author ccronk
 */
public class FlowerListener implements ActionListener {
    private Flower myFlower;
    
    FlowerListener(Flower flower)
    {
        myFlower = flower;
    }
    
    /**
     * When clicked, the flower toggles between alive (true) and dead (false).
     */
    @Override
    public void actionPerformed(ActionEvent event)
    {
        if(!myFlower.isAlive())
        {
            myFlower.setStatus(true);
        }
        else
        {
            myFlower.setStatus(false);
        }
    }
}
