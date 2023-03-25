package theflowergame;

import java.awt.GridLayout;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import javax.swing.JPanel;
import javax.swing.JLabel;
import java.util.Scanner;
import javax.swing.WindowConstants;
import java.awt.Color;

/**
 *
 * @author ccronk
 */
public class GameRunner extends javax.swing.JFrame {

    /**
     * Creates new form GameRunner
     */
    public GameRunner() {
        initComponents();
        initCustomizedComponents();
        garden = new Garden(this);
        garden.createGarden();
        myFlowers = garden.getFlowerGrid();
       
    }
    
    /**
     * sets text, color, and action listeners for all GUI components
     */
    public void initCustomizedComponents()
    {
        //jPanel
        jPanel1.setBackground(BACKGROUND_COLOR);
        jPanel1.setLayout(new GridLayout(Garden.ROWS,Garden.COLUMNS)); //sets the default panel to a grid that can hold buttons
        
        //jFrame
        setTitle("The Flower Game"); //referrs to the JFrame, since GameRunner extends that class
        getContentPane().setBackground(BACKGROUND_COLOR); //had to look this up, basically gets the appearance customization ability
        setDefaultCloseOperation(WindowConstants.EXIT_ON_CLOSE); //didn't see this in the provided setup so I got nervous
        
        //jLabels
        jLabel1.setText("Click on a \"flower\" cell to make it alive. Press Random Fill to get a random starting pattern.");
        jLabel2.setText("Use the console to input the speed and length of the simulation. Then type \"START\" to start."); 
        jLabel3.setText("\"These are the rules of a game. Let it be played upon an infinite two-dimensional grid of flowers.");
        jLabel4.setText("Rule One. A living flower with less than two living neighbors is cut off. It dies.");
        jLabel7.setText("Rule Two. A living flower with two or three living neighbors is connected. It lives.");
        jLabel5.setText("Rule Three. A living flower with more than three living neighbors is starved and overcrowded. It dies.");
        jLabel6.setText("Rule Four. A dead flower with exactly three living neighbors is reborn. It springs back to life.\"");
        
        JLabel[] labels = {jLabel1, jLabel2, jLabel3, jLabel4, jLabel5, jLabel6, jLabel7};
        
        for(JLabel label : labels)
        {
            label.setForeground(Flower.ALIVE);
        }
       
        //jButton
        jButton1.setText("Random Fill");
        jButton1.setBackground(Flower.ALIVE);
        jButton1.addActionListener(
        new ActionListener()
        {
            @Override
            public void actionPerformed(ActionEvent e)
            {
                garden.randomizeFlowers();
            }
        }
        );
    }
     
    /**
     * Runs one "generation" of the game.
     */ 
    public void play()
    {
        for(int ii = 0; ii < Garden.ROWS; ii++)
        {
            for(int jj = 0; jj < Garden.COLUMNS; jj++)
            {
                myFlowers[ii][jj].getNewStatus(); 
            }   
        }
        for(int ii = 0; ii < Garden.ROWS; ii++)
        {
            for(int jj = 0; jj < Garden.COLUMNS; jj++)
            {
                myFlowers[ii][jj].updateStatus();
            }
        }     
    }
     
    /**
     * Adds delay for pattern observation
     * @param pauseTime time in milliseconds? I think?
     */
    public static void pause (int pauseTime)
    {
        try
            {
                Thread.sleep(pauseTime);
            }
            catch(InterruptedException ex)
            {
               Thread.currentThread().interrupt();
            }
    }
    
    //accessor
    public JPanel getPanel()
    {
        return jPanel1;
    } 
    

    /**
     * This method is called from within the constructor to initialize the form.
     * WARNING: Do NOT modify this code. The content of this method is always
     * regenerated by the Form Editor.
     */
    @SuppressWarnings("unchecked")
    // <editor-fold defaultstate="collapsed" desc="Generated Code">//GEN-BEGIN:initComponents
    private void initComponents() {

        jPanel1 = new javax.swing.JPanel();
        jButton1 = new javax.swing.JButton();
        jLabel1 = new javax.swing.JLabel();
        jLabel2 = new javax.swing.JLabel();
        jLabel3 = new javax.swing.JLabel();
        jLabel4 = new javax.swing.JLabel();
        jLabel5 = new javax.swing.JLabel();
        jLabel6 = new javax.swing.JLabel();
        jLabel7 = new javax.swing.JLabel();

        setDefaultCloseOperation(javax.swing.WindowConstants.EXIT_ON_CLOSE);

        jPanel1.setPreferredSize(new java.awt.Dimension(900, 600));

        javax.swing.GroupLayout jPanel1Layout = new javax.swing.GroupLayout(jPanel1);
        jPanel1.setLayout(jPanel1Layout);
        jPanel1Layout.setHorizontalGroup(
            jPanel1Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGap(0, 887, Short.MAX_VALUE)
        );
        jPanel1Layout.setVerticalGroup(
            jPanel1Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGap(0, 573, Short.MAX_VALUE)
        );

        jButton1.setText("jButton1");

        jLabel1.setText("jLabel1");

        jLabel2.setText("jLabel3");

        jLabel3.setText("jLabel3");

        jLabel4.setText("jLabel3");

        jLabel5.setText("jLabel3");

        jLabel6.setText("jLabel3");

        jLabel7.setText("jLabel3");

        javax.swing.GroupLayout layout = new javax.swing.GroupLayout(getContentPane());
        getContentPane().setLayout(layout);
        layout.setHorizontalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addContainerGap(javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addComponent(jLabel3, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                    .addComponent(jLabel4, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                    .addComponent(jLabel5, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                    .addGroup(layout.createSequentialGroup()
                        .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                            .addGroup(layout.createSequentialGroup()
                                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                                    .addComponent(jLabel1, javax.swing.GroupLayout.PREFERRED_SIZE, 770, javax.swing.GroupLayout.PREFERRED_SIZE)
                                    .addComponent(jLabel2, javax.swing.GroupLayout.PREFERRED_SIZE, 734, javax.swing.GroupLayout.PREFERRED_SIZE))
                                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                                .addComponent(jButton1, javax.swing.GroupLayout.PREFERRED_SIZE, 101, javax.swing.GroupLayout.PREFERRED_SIZE))
                            .addComponent(jPanel1, javax.swing.GroupLayout.PREFERRED_SIZE, 887, javax.swing.GroupLayout.PREFERRED_SIZE))
                        .addGap(0, 10, Short.MAX_VALUE))
                    .addComponent(jLabel6, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                    .addComponent(jLabel7, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE))
                .addContainerGap())
        );
        layout.setVerticalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addContainerGap()
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addComponent(jButton1)
                    .addGroup(layout.createSequentialGroup()
                        .addComponent(jLabel1)
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                        .addComponent(jLabel2)))
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(jPanel1, javax.swing.GroupLayout.PREFERRED_SIZE, 573, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(jLabel3)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(jLabel4)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(jLabel7)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(jLabel5)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(jLabel6)
                .addContainerGap(javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE))
        );

        pack();
    }// </editor-fold>//GEN-END:initComponents

    /**
     * Constructs the GameRunner and starts the program.
     * I realized that the main problem with the timer running and not updating was that you couldn't observe the patterns moving.
     * Without being able to watch the patterns, it kind of defeated the point. I asked myself, "why did it work in my other project
     * and not this one? The conclusion I came to was that it was because the play() method was not being called within the main 
     * method. I tried putting the action listener within the main method, too, but it didn't help. This is my (somewhat clunky) workaround.
     * And, hey, it allows the player to set their own observation times.
     */
    public static void main(String args[]) { 
        GameRunner game = new GameRunner();
        game.setVisible(true);       
        Scanner in = new Scanner(System.in);
        
        System.out.println("Enter an integer pause time: (Suggested:70-120)"); //based on my trials, too fast and you can't see it, too slow and the oscilators look weird
        int pauseTime = in.nextInt();
        
        System.out.println("Enter an integer total number of generations: (Suggested: 600+)"); //it can run for a LONG time before stabilizing.
        int totalTime = in.nextInt();
       
        System.out.println("Set desired start pattern, then type \"START\" to run the simulation");
        String input = "";
        while(!input.equals("START")) //a bit of input validation
        {
            input = in.next();
        }        
        for(int timer = 0; timer < 2000000; timer++)
        {
            //giving the viewer a bit more time to get back to the screen
        }
        for(int time = 0; time < totalTime; time++) //runs the game for the inputted amount of generations
            {
                game.play();
                pause(pauseTime);
            }    
    }

    // Variables declaration - do not modify//GEN-BEGIN:variables
    private javax.swing.JButton jButton1;
    private javax.swing.JLabel jLabel1;
    private javax.swing.JLabel jLabel2;
    private javax.swing.JLabel jLabel3;
    private javax.swing.JLabel jLabel4;
    private javax.swing.JLabel jLabel5;
    private javax.swing.JLabel jLabel6;
    private javax.swing.JLabel jLabel7;
    private javax.swing.JPanel jPanel1;
    // End of variables declaration//GEN-END:variables
 
private Flower[][] myFlowers;
private Garden garden;
public static final Color BACKGROUND_COLOR = new Color(0,40,10);

}

